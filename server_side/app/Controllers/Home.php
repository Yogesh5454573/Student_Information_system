<?php

namespace App\Controllers;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
use CodeIgniter\Controller;
use App\Models\Users;
class Home extends BaseController
{
    protected $db;
    protected $datatable;

    public function __construct()
    {
        // parent::__construct();
        $this->db = \Config\Database::connect();
        $this->datatable = $this->db->table('stud_info');
    }

    public function index(): string
    {
        return view('template/header.php') . view('index.php') . view('template/footer.php');
    }




  

    public function getData()
    {
        $data = $this->datatable->get()->getResult();
        $tr = "";
        $i = 1;
        foreach ($data as $row) {
            $tr .= '<tr>
            <td>' . $i . '</td>
            <td>' . $row->First_Name . '</td>
            <td>' . $row->Enter_Age . '</td>
            <td>' . $row->Mother_Tongue . '</td>
            
            <td>' . $row->contact_number . '</td>
            <td>' . $row->email . '</td>
            <td>' . $row->time_stamp . '</td>

            
            </tr>';
            $i++;
        }
        return json_encode($tr);
    }
    public function addData(){
        $data= [
        'First_Name'=>$this->request->getVar('First_Name'),
        'Enter_Age'=>$this->request->getVar('Enter_Age'),
        'Mother_Tongue'=>$this->request->getVar('Mother_Tongue'),
        'contact_number'=>$this->request->getVar('contact_number'),
        'email'=>$this->request->getVar('email'),
     


        

    ];


    $this->datatable->insert($data);
    return json_encode($data);

    }


}
