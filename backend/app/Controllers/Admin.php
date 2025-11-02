<?php namespace App\Controllers;

use App\Models\BoothModel;
use App\Models\SingerModel;
use App\Models\TicketModel;
use CodeIgniter\Controller;

class Admin extends Controller
{
    protected $boothModel;
    protected $singerModel;
    protected $ticketModel;
    protected $session;
    protected $validation;

    public function __construct()
    {
        $this->boothModel = new BoothModel();
        $this->singerModel = new SingerModel();
        $this->ticketModel = new TicketModel();
        $this->session = session();
        $this->validation = \Config\Services::validation();
    }

    /* ---------- DASHBOARD ---------- */
    public function index()
    {
        $data = [
            'title'    => 'Admin Dashboard',
            'booths'   => $this->boothModel->orderBy('id', 'DESC')->findAll(8),
            'singers'  => $this->singerModel->orderBy('id', 'DESC')->findAll(8),
            'tickets'  => $this->ticketModel->orderBy('id', 'DESC')->findAll(8)
        ];
        echo view('dashboard', $data);
    }

    /* ---------- BOOTHS ---------- */
    public function booths()
    {
        $data['booths'] = $this->boothModel->orderBy('id', 'DESC')->findAll();
        echo view('admin/booths', $data);
    }

    public function boothSave()
    {
        $id = $this->request->getPost('id');
        $payload = [
            'name' => $this->request->getPost('name'),
            'location' => $this->request->getPost('location'),
            'description' => $this->request->getPost('description')
        ];

        if (!$this->validate(['name' => 'required|min_length[2]'])) {
            $message = 'Please provide a valid name.';
            return $this->request->isAJAX()
                ? $this->response->setStatusCode(422)->setJSON(['error' => $message])
                : redirect()->back()->with('error', $message)->withInput();
        }

        try {
            $this->boothModel->save(array_filter(array_merge(['id' => $id], $payload), fn($v)=> $v!==null));
            $insertId = $this->boothModel->getInsertID() ?: $id;
            return $this->request->isAJAX()
                ? $this->response->setStatusCode(201)->setJSON(['id'=>$insertId,'name'=>$payload['name']])
                : redirect()->to(base_url('admin'))->with('success','Booth saved.');
        } catch (\Throwable $e) {
            log_message('error',$e->getMessage());
            $msg = 'Could not save booth.';
            return $this->request->isAJAX()
                ? $this->response->setStatusCode(500)->setJSON(['error'=>$msg])
                : redirect()->back()->with('error',$msg);
        }
    }

    public function boothDelete($id = null)
    {
        if (!$id) return redirect()->back();
        $this->boothModel->delete($id);
        $this->session->setFlashdata('success', 'Booth deleted.');
        return redirect()->back();
    }

    public function boothsJson()
    {
        $rows = $this->boothModel->select('id,name,description')->orderBy('id','DESC')->findAll();
        return $this->response->setJSON($rows);
    }

    /* ---------- SINGERS ---------- */
    public function singers()
    {
        $data['singers'] = $this->singerModel->orderBy('id','DESC')->findAll();
        echo view('admin/singers', $data);
    }

    public function singerSave()
    {
        $id = $this->request->getPost('id');
        $payload = [
            'name' => $this->request->getPost('name'),
            'genre' => $this->request->getPost('genre'),
            'performance_date' => $this->request->getPost('performance_date') ?: null,
            'bio' => $this->request->getPost('bio')
        ];

        if (!$this->validate(['name'=>'required|min_length[2]'])) {
            $message = 'Please provide a valid singer name.';
            return $this->request->isAJAX()
                ? $this->response->setStatusCode(422)->setJSON(['error'=>$message])
                : redirect()->back()->with('error',$message)->withInput();
        }

        try {
            $this->singerModel->save(array_filter(array_merge(['id'=>$id], $payload), fn($v)=>$v!==null));
            $insertId = $this->singerModel->getInsertID() ?: $id;
            return $this->request->isAJAX()
                ? $this->response->setStatusCode(201)->setJSON(['id'=>$insertId,'name'=>$payload['name']])
                : redirect()->to(base_url('admin'))->with('success','Singer saved.');
        } catch (\Throwable $e) {
            log_message('error',$e->getMessage());
            $msg = 'Could not save singer.';
            return $this->request->isAJAX()
                ? $this->response->setStatusCode(500)->setJSON(['error'=>$msg])
                : redirect()->back()->with('error',$msg);
        }
    }

    public function singerDelete($id = null)
    {
        if (!$id) return redirect()->back();
        $this->singerModel->delete($id);
        $this->session->setFlashdata('success','Singer deleted.');
        return redirect()->back();
    }

    public function singersJson()
    {
        $rows = $this->singerModel->select('id,name,genre,performance_date')->orderBy('id','DESC')->findAll();
        return $this->response->setJSON($rows);
    }

    /* ---------- TICKETS ---------- */
    public function tickets()
    {
        $data['tickets'] = $this->ticketModel->orderBy('id','DESC')->findAll();
        echo view('admin/tickets', $data);
    }

    public function ticketSave()
    {
        $id = $this->request->getPost('id');
        $payload = [
            'type'        => $this->request->getPost('type'),
            'available'   => (int)($this->request->getPost('available') ?? 0),
            'price'       => (float)($this->request->getPost('price') ?? 0),
            'description' => $this->request->getPost('description') ?? ''
        ];

        $rules = [
            'type'      => 'required|min_length[2]',
            'available' => 'required|integer|greater_than_equal_to[0]',
            'price'     => 'required|numeric|greater_than_equal_to[0]'
        ];

        if (!$this->validate($rules)) {
            $message = 'Please fill all required ticket fields correctly.';
            return $this->request->isAJAX()
                ? $this->response->setStatusCode(422)->setJSON(['error'=>$message])
                : redirect()->back()->with('error',$message)->withInput();
        }

        try {
            $this->ticketModel->save(array_filter(array_merge(['id'=>$id], $payload), fn($v)=>$v!==null));
            $insertId = $this->ticketModel->getInsertID() ?: $id;
            return $this->request->isAJAX()
                ? $this->response->setStatusCode(201)->setJSON(['success'=>true,'id'=>$insertId,'type'=>$payload['type']])
                : redirect()->to(base_url('admin'))->with('success','Ticket saved.');
        } catch (\Throwable $e) {
            log_message('error',$e->getMessage());
            $msg = 'Could not save ticket.';
            return $this->request->isAJAX()
                ? $this->response->setStatusCode(500)->setJSON(['error'=>$msg])
                : redirect()->back()->with('error',$msg);
        }
    }

    public function ticketDelete($id = null)
    {
        if (!$id) return redirect()->back();
        $this->ticketModel->delete($id);
        $this->session->setFlashdata('success','Ticket deleted.');
        return redirect()->back();
    }

    public function ticketsJson()
    {
        $rows = $this->ticketModel->select('id,type,available,price')->orderBy('id','DESC')->findAll();
        return $this->response->setJSON($rows);
    }
}
