<?php 

namespace App\Traits;

use DB;
use App\Models\Menu;
use App\Models\UserMenu;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
trait ConvertionMethods
{
    public function userNavbar($id){
        
        $permissions = UserMenu::where('user_id',$id)->join('menus','menus.id','user_menus.menu_id')
                    ->select('menu_id')->get();

        $permissionsId = collect($permissions)->pluck('menu_id')->toArray();

        $menusGeneral = $this->menusGeneral();

        $menus = $menusGeneral['menus'];

        $menus->map(function($item,$index) use ($permissionsId){
         
            $isHideParent = true;
            $item->details->map(function($subitem,$index)use ($permissionsId,&$isHideParent){                
                
                $isHide = true;
                $subitem->details->map(function($subsubitem,$index)use ($permissionsId,&$isHide){
                    if(in_array($subsubitem->id, $permissionsId)){
                        $isHide=false;
                    }
                    $subsubitem->hide = !in_array($subsubitem->id, $permissionsId);                   
                    return $subsubitem;
                });
                $subitem->hide = count($subitem->details)==0 ? !in_array($subitem->id, $permissionsId) :  $isHide;   
                if(!$subitem->hide){
                    $isHideParent=false;
                }
                return $subitem;
            });
           $item->hide = $isHideParent;
            return $item;
        });
        $userAccess = [];
        foreach ($menus as $key => $value) {
            //1st lvl
            if(!$value->hide){
               
                $item = new \stdClass();
                $item->navheader = $value->navheader;               
                array_push($userAccess,$item);      
                //2nd lvl
                foreach ($value->details as $j => $sndLvl) {
                    if(!$sndLvl->hide){
                        $child1 = new \stdClass();
                       if($sndLvl->haveChild  ==0){
                            $child1->url = route($sndLvl->url);
                            $child1->name_url = $sndLvl->name_url;
                            $child1->name = $sndLvl->name;
                            $child1->slug = $sndLvl->slug;
                            $child1->icon = $sndLvl->icon;
                            $child1->badgeClass = $sndLvl->badgeClass;
                       }else {
                            $child1->url = "";
                            $child1->name_url = "";
                            $child1->name = $sndLvl->name;
                            $child1->slug = $sndLvl->slug;
                            $child1->icon = $sndLvl->icon;
                            $child1->badgeClass = $sndLvl->badgeClass;
                            $submenus = [];
                            foreach ($sndLvl->details as $l => $thdLvl) {
                                if(!$thdLvl->hide){

                                    $child = new \stdClass();
                                    $child->url = route($thdLvl->url);
                                    $child->name = $thdLvl->name;
                                    $child->icon = $thdLvl->icon;   
                                    $submenus[] = $child;     
                                }   
                            } 
                            $child1->submenu=$submenus ;
                           
                       }
                       $userAccess[]=$child1;
                     
                    }
                }
            }
        }

        return $userAccess;
    }

    public function menusGeneral(){

        $menus = Menu::with(['details' => function ($query) {
                    $query->select('id', 'name_url','url','name','slug','badgeClass','icon','haveChild', 'item_id')
                        ->with(['details' => function ($query) {
                            $query->select('id', 'name_url','url','name','slug','badgeClass','icon', 'haveChild', 'item_id'); 
                    }]); 
                }])
                ->where('haveChild',1)
                ->whereNull('item_id')
                ->select('navheader','id')
                ->orderBy('order','asc')->get();
        
        $tableMenus = [];

        $menus->map(function($item,$index) use (&$tableMenus){
            $item->showChecked = false;
            $item->isTitle = true;
            $tableMenus[]=$item;
            $item->details->map(function($subitem,$index)use (&$tableMenus){
                $subitem->showChecked = false;
                $subitem->isTitle = $subitem->haveChild ==0 ?false : true;
                $subitem->isAdd = false;
                $subitem->isEdit = false;
                $subitem->isDelete = false;
                $subitem->isList = false;
                $tableMenus[]=$subitem;
                $subitem->details->map(function($subsubitem,$index) use (&$tableMenus){
                    $subsubitem->showChecked = false;
                    $subsubitem->isTitle = $subsubitem->haveChild ==0 ?false : true;
                    $subsubitem->isAdd = false;
                    $subsubitem->isEdit = false;
                    $subsubitem->isDelete = false;
                    $subsubitem->isList = false;
                    $tableMenus[]=$subsubitem;
                    return $subsubitem;
                });
                return $subitem;
            });
            return $item;
        });

        $response = [
            'menus'=>$menus,
            'table'=>$tableMenus
        ];

        return $response;
    }
    public function mos_limpiador_campo($var){
        return trim(utf8_decode(strtr($var, array("'" => "''", "¥" => 'Ñ','Ÿ' => "Ñ", "º"=>"°","ª"=>"°"))));
    }
   
    public function escape_like($string){
        $search = array('%', '_');
        $replace   = array('\%', '\_');
        return str_replace($search, $replace, $string);
    }
    public function getMonthName($month) {
        $completeName = array(
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        );
    
        return $completeName[$month];  
    }
    public function getInitialLetter($cadena) {
        $palabras = explode(' ', $cadena);
      
        $iniciales = '';
        foreach ($palabras as $palabra) {
          if (strlen($palabra) > 3) {
            $iniciales .= substr($palabra, 0, 1);
          }
        }
      
        return $iniciales;
    }

 
    public function replaceCharacters($texto) {
        $caracteres = array(
            "á" => "a",
            "é" => "e",
            "í" => "i",
            "ó" => "o",
            "ú" => "u",
            "ñ" => "n",
            "ü" => "u",
            "Á" => "A",
            "É" => "E",
            "Í" => "I",
            "Ó" => "O",
            "Ú" => "U",
            "Ñ" => "N",
            "Ü" => "U",
            "\r" => "",
            "\n" => "",
            "\t" => "",
            "\v" => "",
            "\0" => "",
            "\x0B" => "",
            "\f" => ""
        );
        return trim(strtr($texto, $caracteres));
    }
 
    public function transformNumberToMonth($month){
	    $months["01"]="Enero";
	    $months["02"]="Febrero";
	    $months["03"]="Marzo";
	    $months["04"]="Abril";
	    $months["05"]="Mayo";
	    $months["06"]="Junio";
	    $months["07"]="Julio";
	    $months["08"]="Agosto";
	    $months["09"]="Setiembre";
	    $months["10"]="Octubre";
	    $months["11"]="Noviembre";
	    $months["12"]="Diciembre";

	    return $months[$month];
	  
	}
    public function filterArrayByKeys($input,$column_keys)
	{
	    $result      = array();
	    $column_keys = array_flip($column_keys); // getting keys as values
	    foreach ($input as $key => $val) {
	         // getting only those key value pairs, which matches $column_keys
	        $result[$key] = array_intersect_key($val, $column_keys);
	    }
	    return $result;
	}

    public function addFile($disk, $name_folder, $file, $name, $last_name = null)
    {
        $ext = "." . pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION);
        $filename = $name_folder . '/' . str_slug($this->limpiarString($name), "-") . $ext;

        if (Storage::disk($disk)->exists($filename)) {
            $this->deleteFile($disk, $name_folder, $filename);
        }

        if (!is_null($last_name)) {
            if (Storage::disk($disk)->exists($last_name)) {
                $this->deleteFile($disk, $name_folder, $last_name);
            }
        }
        Storage::disk($disk)->put($filename, File::get($file));
        return $filename;
    }
    
}   