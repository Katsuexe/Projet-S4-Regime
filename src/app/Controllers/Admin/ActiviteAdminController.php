<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class ActiviteAdminController extends BaseController
{
    public function index()
    {
        $db = \Config\Database::connect();
        $activites = $db->table('activites')->get()->getResultArray();
        
        return view('admin/activites/index', [
            'title' => 'Gestion des activités',
            'activites' => $activites
        ]);
    }
    
    public function creer()
    {
        return view('admin/activites/create', [
            'title' => 'Créer une activité'
        ]);
    }
    
    public function store()
    {
        $db = \Config\Database::connect();
        
        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'calories_h' => $this->request->getPost('calories_h'),
            'duree_min' => $this->request->getPost('duree_min')
        ];
        
        if ($db->table('activites')->insert($data)) {
            return redirect()->to(site_url('admin/activites'))->with('success', 'Activité créée.');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la création.');
        }
    }
    
    public function modifier($id)
    {
        $db = \Config\Database::connect();
        $activite = $db->table('activites')->where('id', $id)->get()->getRowArray();
        
        return view('admin/activites/edit', [
            'title' => 'Modifier une activité',
            'activite' => $activite
        ]);
    }
    
    public function update($id)
    {
        $db = \Config\Database::connect();
        
        $data = [
            'nom' => $this->request->getPost('nom'),
            'description' => $this->request->getPost('description'),
            'calories_h' => $this->request->getPost('calories_h'),
            'duree_min' => $this->request->getPost('duree_min')
        ];
        
        if ($db->table('activites')->where('id', $id)->update($data)) {
            return redirect()->to(site_url('admin/activites'))->with('success', 'Activité modifiée.');
        } else {
            return redirect()->back()->with('error', 'Erreur lors de la modification.');
        }
    }
    
    public function supprimer($id)
    {
        $db = \Config\Database::connect();
        if ($db->table('activites')->where('id', $id)->delete()) {
            return redirect()->to(site_url('admin/activites'))->with('success', 'Activité supprimée.');
        } else {
            return redirect()->to(site_url('admin/activites'))->with('error', 'Impossible de supprimer cette activité (utilisée).');
        }
    }
}
