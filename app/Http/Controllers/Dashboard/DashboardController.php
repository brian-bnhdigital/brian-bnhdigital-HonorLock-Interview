<?php

namespace App\Http\Controllers\Dashboard;

class DashboardController extends Controller
{
    public function getIndex(){
        $this->data['title'] = 'Pull Carvana Search Results';
        return view('dashboard.index',$this->data);
    }

}
