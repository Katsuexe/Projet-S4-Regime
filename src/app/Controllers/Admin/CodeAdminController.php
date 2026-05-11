<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class CodeAdminController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $codes = $db->query('
            SELECT c.id, c.code, c.montant, c.is_used, u.prenom, u.nom, c.used_at 
            FROM codes c
            LEFT JOIN users u ON u.id = c.used_by
            ORDER BY c.id DESC
        ')->getResultArray();
        
        return view('admin/codes/index', [
            'title' => 'Gestion des codes',
            'codes' => $codes
        ]);
    }

    public function exportCsv()
    {
        $db = \Config\Database::connect();

        $codes = $db->query('
            SELECT c.id, c.code, c.montant, c.is_used, u.prenom, u.nom, c.used_at
            FROM codes c
            LEFT JOIN users u ON u.id = c.used_by
            ORDER BY c.id DESC
        ')->getResultArray();

        $lines = [
            ['ID', 'Code', 'Montant', 'Statut', 'Utilise par', 'Date utilisation'],
        ];

        foreach ($codes as $code) {
            $lines[] = [
                (string) $code['id'],
                (string) $code['code'],
                number_format((float) $code['montant'], 2, '.', ''),
                (int) $code['is_used'] === 1 ? 'Utilise' : 'Libre',
                (int) $code['is_used'] === 1 ? trim(($code['prenom'] ?? '') . ' ' . ($code['nom'] ?? '')) : '',
                (string) ($code['used_at'] ?? ''),
            ];
        }

        return $this->csvResponse('codes-promos-' . date('Y-m-d') . '.csv', $lines);
    }
    
    public function creer()
    {
        return view('admin/codes/create', [
            'title' => 'Générer des codes'
        ]);
    }
    
    public function store()
    {
        $qte     = (int) $this->request->getPost('quantite');
        $montant = (float) $this->request->getPost('montant');
        $prefix  = strtoupper($this->request->getPost('prefixe') ?: 'PROMO');
        
        if ($qte <= 0 || $montant <= 0) {
            return redirect()->back()->with('error', 'Quantité et montant doivent être supérieurs à zéro.');
        }

        $db = \Config\Database::connect();
        $db->transStart();
        
        $codesData = [];
        for ($i = 0; $i < $qte; $i++) {
            $codeStr = $prefix . '-' . strtoupper(bin2hex(random_bytes(4)));
            $codesData[] = [
                'code' => $codeStr,
                'montant' => $montant,
                'is_used' => 0
            ];
        }
        
        $db->table('codes')->insertBatch($codesData);
        $db->transComplete();
        
        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Erreur lors de la génération.');
        }

        return redirect()->to(site_url('admin/codes'))->with('success', "$qte codes générés avec succès.");
    }

    private function csvResponse(string $filename, array $lines)
    {
        $handle = fopen('php://temp', 'r+');
        fwrite($handle, "\xEF\xBB\xBF");

        foreach ($lines as $line) {
            fputcsv($handle, $line, ';');
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=UTF-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($csv);
    }
}
