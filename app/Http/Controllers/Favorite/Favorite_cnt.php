<?php

namespace App\Http\Controllers\Favorite;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
  use Illuminate\Validation\Rules;
  use Elibyy\TCPDF\Facades\TCPDF;
  use Alkoumi\LaravelHijriDate\Hijri;

  use App\Models\Favorite;
  use App\Models\Pizza;

class Favorite_cnt extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function create(Request $request)
    { 
    
        return view('favorite.create');
    }

    public function store(Request $request)
      {
          //if u need uniqe add in array 'unique:'Table::class
          //if u need null add in array nullable
          $request->validate([
            'fav_add_date' => ['string', 'max:55'  ,'nullable' ],
                    'name' => ['string', 'max:255' , 'required', ],
                     'age' => ['string' , 'required',],
                    'fav_pizza' => 'required',
                  
              ]);
              
              $txt_para = '';
  
              if ($request->has('fav_pizza')) {
                  $txt_para = implode(',', $request->input('fav_pizza'));
                  $txt_para = rtrim($txt_para, ',');
              }

                $v_favpizza = new Favorite();
          
                   $v_favpizza->fav_add_date = $request->input('fav_add_date');
                   
                   $v_favpizza->name = $request->input('name');
                   
                  $v_favpizza->age = $request->input('age');
                   
                 $v_favpizza->fav_pizza =  $txt_para ;
                 $v_favpizza->fav_log = set_reg_stamp('إضافة');
              $v_favpizza->save();

              //return redirect()->route('myfrind.index');
              return response()->json('2');
            }
            
    public function show(string $id)
        {
            $id = dec($id);
            return view('favorite.show',[
                'listings' => Favorite::findOrFail($id)
            ]);
        }
        
    public function edit(string $id)
        {
          $id = dec($id);
          return view('favorite.edit',[
              'listings' => Favorite::findOrFail($id)
          ]);
        
    
        }

        

    public function update(Request $request)
        {
          $v_favpizza = Favorite::findOrFail(dec(request()->input('id')));
          $request->validate([
            'fav_add_date' => ['string', 'max:55'  ,'nullable' ],
            'name' => ['string', 'max:255' , 'required', ],
             'age' => ['string' ,'required',],
            'fav_pizza' => 'required',
                        
                ]);
                if ($request->has('fav_pizza') and $request->input('fav_pizza')!= $v_favpizza->fav_pizza) {
                    $txt_para = '';
                    $txt_para = implode(',', $request->input('fav_pizza'));
                    $txt_para = rtrim($txt_para, ',');
                }else{
                    $txt_para = $v_favpizza->fav_pizza;
                }
            
              $v_favpizza->fav_add_date = $request->input('fav_add_date');
                
              $v_favpizza->name = $request->input('name');
                
              $v_favpizza->age = $request->input('age');
                
              $v_favpizza->fav_pizza = $txt_para;
            
                
              $v_favpizza->fav_log .= set_reg_stamp('تحديث');
            $v_favpizza->save();
            //return redirect()->route('myfrind.index');
            return response()->json('2');
            }

    public function destroy(string $id)
          {
            $idx= dec($id);
            $delx = Favorite::findOrFail($idx);
            $delx->delete();
            return response()->json('2');
          }

    public function list(Request $request)
      {
          $query = $request->input('q');
      
          if (!empty($query)) {
              $listings = Favorite::
              where('id', 'LIKE', "%$query%")
        ->orWhere('fav_add_date', 'LIKE', "%$query%")
                ->orWhere('name', 'LIKE', "%$query%")
                ->orWhere('age', 'LIKE', "%$query%")
                ->orWhere('fav_pizza', 'LIKE', "%$query%")
            
                
                      ->orderBy("id", "desc")
                      ->paginate(20);
          } else {
              $listings = Favorite::orderBy("id", "desc")->paginate(20);
          }
      
          return view('favorite.list', compact('listings'));
      
        }
      
    public function rep()
      {
          return view('favorite.rep');
      }

    public function rep_excel(Request $request)
      {
        $fav_add_date= $request->input('fav_add_date');
                    $name= $request->input('name');
                    $age= $request->input('age');
                    $fav_pizza= $request->input('fav_pizza');
                    
                   
                    
              $query = Favorite::query();
              
                    if (!empty($fav_add_date)) {
                       $query->orWhere('fav_add_date', 'LIKE', "%$fav_add_date%");
                    }
                    
                    if (!empty($name)) {
                       $query->orWhere('name', 'LIKE', "%$name%");
                    }
                    
                    if (!empty($age)) {
                       $query->orWhere('age', 'LIKE', "%$age%");
                    }
                    
                    if (!empty($fav_pizza)) {
                       $query->orWhere('fav_pizza', 'LIKE', "%$fav_pizza%");
                    }
                    
                    
                    
                      $listings = $query->orderBy("id", "desc")->get();
                      $listingsCount = $query->count();
  
                  return view('favorite.excel', compact('listings', 'listingsCount'));
      }
    public function rep_pdf(Request $request)
            {
                $fav_add_date= $request->input('fav_add_date');
                $name= $request->input('name');
                $age= $request->input('age');
                $fav_pizza= $request->input('fav_pizza');
                
               
                
          $query = Favorite::query();
          
                if (!empty($fav_add_date)) {
                   $query->orWhere('fav_add_date', 'LIKE', "%$fav_add_date%");
                }
                
                if (!empty($name)) {
                   $query->orWhere('name', 'LIKE', "%$name%");
                }
                
                if (!empty($age)) {
                   $query->orWhere('age', 'LIKE', "%$age%");
                }
                
                if (!empty($fav_pizza)) {
                   $query->orWhere('fav_pizza', 'LIKE', "%$fav_pizza%");
                }
                
                
                
                  $listings = $query->orderBy("id", "desc")->get();
                  $listingsCount = $query->count();

                  $view = \View::make('favorite.pdf', compact('listings', 'listingsCount'));
                  $html_content = $view->render();
                     
          $pdf = new TCPDF;
          
          $pdf::setHeaderCallback(function($pdf) use ( $listingsCount){
  
              $listingsCountx = $listingsCount;
              $dgx =  Hijri::Date('Y/m/d'); 
              $hs='
              <style>
              .tbg{
                  background:#C6C6C6 ;
              }
              .text-center{
                text-align: center;
              }
              .text-right{
                  text-align: right;
                }
              .mtx{
                  margin-top:5px !important;
              }
              </style>
              <table cellspacing="0" cellpadding="0" border="0" width="100%">
              <thead>
                  <tr>
                   <td class="text-center">
                       '.env('prog_header_pdf').'<br>
                           عدد السجلات : '. $listingsCountx .'
                   </td>
                   
                    <td class="text-center" style="font-size: medium">
                      <h4><b>تقرير <br> بيتزا</b></h4>
                    </td>
                    
                    <td class="text-center" style="vertical-align: top;">
                     <img height="90px" src="'.env('prog_logo_sm').'">
                     <br>
                     تاريخ التقرير : '. $dgx .'
                     </td>
                  
                  </tr>
              </thead>
          </table>
                <hr>';
              $pdf->SetFont('skyb', 'B', 12);
              $pdf->writeHTML($hs, true, false, true, false, '');          
          });
          $pdf::setFooterCallback(function($pdf){
              $pdf->SetY(-11);
              $pdf->SetRightMargin(5);
              $pdf->SetLeftMargin(5);
              $pdf->SetFont('skyb', 'I', 8);
              $pdf->Cell(0, 10, 'صفحة '.$pdf->getAliasNumPage().'/'.$pdf->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
              $pdf->Cell(0, 10, env('prog_name'), 0, true, 'L', 0, '', 0, false, 'T', 'L');
              $pdf->Cell(0, 10, env('spfooter'), 0, true, 'R', 0, '', 0, true, 'B', 'R');            
          });
          
          $pdf::SetTitle('مفضلاتي');
          $pdf::SetRTL(TRUE);
          $pdf::setMargins(5, 40, 5); //PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT
          $pdf::setHeaderMargin(5);
          $pdf::setFooterMargin(10);
          $pdf::setAutoPageBreak(TRUE, 25);
          $pdf::setImageScale(1.3);
      
          $pdf::AddPage();
          $pdf::SetFont('skyb', '', 10);
          $pdf::writeHTML($html_content, false, false, false, false, '');
          $pdf::Output('favorite_rep.pdf');
      }
      
                  
      
        

}
