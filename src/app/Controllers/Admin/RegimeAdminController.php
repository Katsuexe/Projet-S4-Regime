<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class RegimeAdminController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        
        $regimes = $db->table('regimes')->get()->getResultArray();
        
        foreach ($regimes as &$r) {
            $r['durees'] = $db->table('regime_durees')->where('regime_id', $r['id'])->get()->getResultArray();
        }
        
        return view('admin/regimes/index', [
            'title' => 'Gestion des régimes',
            'regimes' => $regimes
        ]);
    }

    public function exportCsv()
    {
        $db = \Config\Database::connect();
        $regimes = $db->table('regimes')->orderBy('id', 'DESC')->get()->getResultArray();

        $lines = [
            ['ID', 'Nom', 'Description', '% Viande', '% Poisson', '% Volaille', 'Delta poids min', 'Delta poids max', 'Durees'],
        ];

        foreach ($regimes as $regime) {
            $durees = $db->table('regime_durees')
                ->where('regime_id', $regime['id'])
                ->orderBy('duree_jours', 'ASC')
                ->get()
                ->getResultArray();

            $dureesLabel = array_map(
                static fn(array $duree): string => $duree['duree_jours'] . 'j: ' . number_format((float) $duree['prix'], 2, '.', '') . ' Ar',
                $durees
            );

            $lines[] = [
                (string) $regime['id'],
                (string) $regime['nom'],
                (string) $regime['description'],
                (string) $regime['pct_viande'],
                (string) $regime['pct_poisson'],
                (string) $regime['pct_volaille'],
                (string) $regime['delta_poids_min'],
                (string) $regime['delta_poids_max'],
                implode(' | ', $dureesLabel),
            ];
        }

        return $this->csvResponse('regimes-' . date('Y-m-d') . '.csv', $lines);
    }
    
    public function creer()
    {
        return view('admin/regimes/create', [
            'title' => 'Créer un régime'
        ]);
    }
    
    public function store()
    {
        $validationError = $this->validateRegimePayload();
        if ($validationError !== null) {
            return redirect()->back()->withInput()->with('error', $validationError);
        }

        $db = \Config\Database::connect();
        $db->transStart();
        
        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'pct_viande' => $this->request->getPost('pct_viande'),
            'pct_poisson' => $this->request->getPost('pct_poisson'),
            'pct_volaille' => $this->request->getPost('pct_volaille'),
            'delta_poids_min' => $this->request->getPost('delta_poids_min'),
            'delta_poids_max' => $this->request->getPost('delta_poids_max')
        ];
        
        $db->table('regimes')->insert($data);
        $regime_id = $db->insertID();
        
        $durees = $this->request->getPost('durees');
        if ($durees && is_array($durees)) {
            $durees_data = [];
            foreach ($durees as $d) {
                if (isset($d['jours']) && isset($d['prix'])) {
                    $durees_data[] = [
                        'regime_id' => $regime_id,
                        'duree_jours' => $d['jours'],
                        'prix' => $d['prix']
                    ];
                }
            }
            if (!empty($durees_data)) {
                $db->table('regime_durees')->insertBatch($durees_data);
            }
        }
        
        $db->transComplete();
        
        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Erreur lors de la création.');
        }
        
        return redirect()->to(site_url('admin/regimes'))->with('success', 'Régime créé.');
    }
    
    public function modifier($id)
    {
        $db = \Config\Database::connect();
        
        $regime = $db->table('regimes')->where('id', $id)->get()->getRowArray();
        $regime['durees'] = $db->table('regime_durees')->where('regime_id', $id)->get()->getResultArray();
        
        return view('admin/regimes/edit', [
            'title' => 'Modifier un régime',
            'regime' => $regime
        ]);
    }
    
    public function update($id)
    {
        $validationError = $this->validateRegimePayload();
        if ($validationError !== null) {
            return redirect()->back()->withInput()->with('error', $validationError);
        }

        $db = \Config\Database::connect();
        $db->transStart();
        
        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'pct_viande' => $this->request->getPost('pct_viande'),
            'pct_poisson' => $this->request->getPost('pct_poisson'),
            'pct_volaille' => $this->request->getPost('pct_volaille'),
            'delta_poids_min' => $this->request->getPost('delta_poids_min'),
            'delta_poids_max' => $this->request->getPost('delta_poids_max')
        ];
        
        $db->table('regimes')->where('id', $id)->update($data);
        
        $db->table('regime_durees')->where('regime_id', $id)->delete();
        
        $durees = $this->request->getPost('durees');
        if ($durees && is_array($durees)) {
            $durees_data = [];
            foreach ($durees as $d) {
                if (isset($d['jours']) && isset($d['prix'])) {
                    $durees_data[] = [
                        'regime_id' => $id,
                        'duree_jours' => $d['jours'],
                        'prix' => $d['prix']
                    ];
                }
            }
            if (!empty($durees_data)) {
                $db->table('regime_durees')->insertBatch($durees_data);
            }
        }
        
        $db->transComplete();
        
        if ($db->transStatus() === FALSE) {
            return redirect()->back()->with('error', 'Erreur lors de la modification.');
        }
        
        return redirect()->to(site_url('admin/regimes'))->with('success', 'Régime modifié.');
    }
    
    public function supprimer($id)
    {
        $db = \Config\Database::connect();

        $isUsed = $db->table('user_regimes')->where('regime_id', $id)->countAllResults() > 0;
        if ($isUsed) {
            return redirect()->to(site_url('admin/regimes'))->with('error', 'Suppression impossible : ce regime est deja souscrit par au moins un utilisateur.');
        }

        $db->table('regimes')->where('id', $id)->delete();
        return redirect()->to(site_url('admin/regimes'))->with('success', 'Régime supprimé.');
    }

    private function validateRegimePayload(): ?string
    {
        $pctViande = (float) $this->request->getPost('pct_viande');
        $pctPoisson = (float) $this->request->getPost('pct_poisson');
        $pctVolaille = (float) $this->request->getPost('pct_volaille');
        $total = round($pctViande + $pctPoisson + $pctVolaille, 2);

        if ($total !== 100.0) {
            return 'La somme des pourcentages viande + poisson + volaille doit etre egale a 100.';
        }

        $durees = $this->request->getPost('durees');
        if (! is_array($durees) || $durees === []) {
            return 'Ajoutez au moins une duree avec son prix.';
        }

        foreach ($durees as $index => $duree) {
            $jours = (int) ($duree['jours'] ?? 0);
            $prix = (float) ($duree['prix'] ?? 0);

            if ($jours <= 0 || $prix <= 0) {
                return 'Chaque duree doit contenir un nombre de jours et un prix valides.';
            }

            if ($index > 20) {
                return 'Trop de durees soumises en une seule fois.';
            }
        }

        return null;
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
