<?php
  
  namespace App\Http\Controllers\Pizza;
  
  use App\Http\Controllers\Controller;
  use Illuminate\Http\Request;
  use Illuminate\Support\Facades\Hash;
  use Illuminate\Validation\Rules;
  
  use Elibyy\TCPDF\Facades\TCPDF;
  use Alkoumi\LaravelHijriDate\Hijri;
  
  use App\Models\Pizza;
  
class Pizza_cnt extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function create()
    {
        return view('pizza.create');
    }

    public function store(Request $request)
      {
          //if u need uniqe add in array 'unique:'Table::class
          //if u need null add in array nullable
          $request->validate([
            'my_p_add_date' => ['string', 'max:55'  ,'nullable' ],
                    'my_p_name' => ['string', 'max:255' , 'required', ],
                     'my_p_price' => ['string' , 'required',],
                    'my_p_type' => ['string', 'max:255' ,'required' ],
                    'my_p_toppings' => ['nullable' ],
                    'my_p_size' => ['string', 'max:255' , 'required', ],
                  
              ]);
              $txt_para = '';
  
              if ($request->has('my_p_toppings')) {
                  $txt_para = implode(',', $request->input('my_p_toppings'));
                  $txt_para = rtrim($txt_para, ',');
              }
          
           //if u need check is have value or exisit //if ($request->has('ui_para')) {}
            $v_mypizza = new Pizza();
          
                   $v_mypizza->my_p_add_date = $request->input('my_p_add_date');
                   
                   $v_mypizza->my_p_name = $request->input('my_p_name');
                   
                  $v_mypizza->my_p_price = $request->input('my_p_price');
                   
                   $v_mypizza->my_p_type = $request->input('my_p_type');
                   
                   $v_mypizza->my_p_toppings = $txt_para;
                   
                  $v_mypizza->my_p_size = $request->input('my_p_size');
                   
           $v_mypizza->mypizza_log = set_reg_stamp('إضافة');
              $v_mypizza->save();
              //return redirect()->route('myfrind.index');
              return response()->json('2');
            }
            
    public function show(string $id)
        {
            $id = dec($id);
            return view('pizza.show',[
                'listings' => Pizza::findOrFail($id)
            ]);
        }
        
    public function edit(string $id)
        {
            $id = dec($id);
            return view('pizza.edit',[
                'listings' => Pizza::findOrFail($id)
            ]);
        }

    public function update(Request $request)
        {
          $v_mypizza = Pizza::findOrFail(dec(request()->input('id')));
          $request->validate([
            'my_p_add_date' => ['string', 'max:55'  ,'nullable' ],
                'my_p_name' => ['string', 'max:255' , 'required', ],
                'my_p_price' => ['string' , 'required',],
                'my_p_type' => ['string', 'max:255' ,'required' ],
                'my_p_toppings' => ['nullable' ],
                'my_p_size' => ['string', 'max:255' , 'required', ],
                        
                ]);

                if ($request->has('my_p_toppings') and $request->input('my_p_toppings')!= $v_mypizza->my_p_toppings) {
                  $txt_para = '';
                  $txt_para = implode(',', $request->input('my_p_toppings'));
                  $txt_para = rtrim($txt_para, ',');
              }else{
                  $txt_para = $v_mypizza->ui_para;
              }
            
              $v_mypizza->my_p_add_date = $request->input('my_p_add_date');
                
              $v_mypizza->my_p_name = $request->input('my_p_name');
                
              $v_mypizza->my_p_price = $request->input('my_p_price');
                
              $v_mypizza->my_p_type = $request->input('my_p_type');
                
              $v_mypizza->my_p_toppings = $txt_para;
                
              $v_mypizza->my_p_size = $request->input('my_p_size');
                
            $v_mypizza->mypizza_log .= set_reg_stamp('تحديث');
            $v_mypizza->save();
            //return redirect()->route('myfrind.index');
            return response()->json('2');
            }

    public function destroy(string $id)
          {
            $idx= dec($id);
            $delx = Pizza::findOrFail($idx);
            $delx->delete();
            return response()->json('2');
          }

    public function list(Request $request)
      {
          $query = $request->input('q');
      
          if (!empty($query)) {
              $listings = Pizza::
              where('id', 'LIKE', "%$query%")
        ->orWhere('my_p_add_date', 'LIKE', "%$query%")
                ->orWhere('my_p_name', 'LIKE', "%$query%")
                ->orWhere('my_p_price', 'LIKE', "%$query%")
                ->orWhere('my_p_type', 'LIKE', "%$query%")
                ->orWhere('my_p_toppings', 'LIKE', "%$query%")
                ->orWhere('my_p_size', 'LIKE', "%$query%")
                
                      ->orderBy("id", "desc")
                      ->paginate(20);
          } else {
              $listings = Pizza::orderBy("id", "desc")->paginate(20);
          }
      
          return view('pizza.list', compact('listings'));
      }
      
    public function rep()
      {
          return view('pizza.rep');
      }

    public function rep_excel(Request $request)
      {
        $my_p_add_date= $request->input('my_p_add_date');
                    $my_p_name= $request->input('my_p_name');
                    $my_p_price= $request->input('my_p_price');
                    $my_p_type= $request->input('my_p_type');
                    $my_p_toppings= $request->input('my_p_toppings');
                    $my_p_size= $request->input('my_p_size');
                    
              $query = Pizza::query();
              
                    if (!empty($my_p_add_date)) {
                       $query->orWhere('my_p_add_date', 'LIKE', "%$my_p_add_date%");
                    }
                    
                    if (!empty($my_p_name)) {
                       $query->orWhere('my_p_name', 'LIKE', "%$my_p_name%");
                    }
                    
                    if (!empty($my_p_price)) {
                       $query->orWhere('my_p_price', 'LIKE', "%$my_p_price%");
                    }
                    
                    if (!empty($my_p_type)) {
                       $query->orWhere('my_p_type', 'LIKE', "%$my_p_type%");
                    }
                    
                    if (!empty($my_p_toppings)) {
                       $query->orWhere('my_p_toppings', 'LIKE', "%$my_p_toppings%");
                    }
                    
                    if (!empty($my_p_size)) {
                       $query->orWhere('my_p_size', 'LIKE', "%$my_p_size%");
                    }
                    
                      $listings = $query->orderBy("id", "desc")->get();
                      $listingsCount = $query->count();
  
                  return view('pizza.excel', compact('listings', 'listingsCount'));
      }
    public function rep_pdf(Request $request)
            {
                $my_p_add_date= $request->input('my_p_add_date');
                $my_p_name= $request->input('my_p_name');
                $my_p_price= $request->input('my_p_price');
                $my_p_type= $request->input('my_p_type');
                $my_p_toppings= $request->input('my_p_toppings');
                $my_p_size= $request->input('my_p_size');
                  
            $query = Pizza::query();
            
                          if (!empty($my_p_add_date)) {
                             $query->orWhere('my_p_add_date', 'LIKE', "%$my_p_add_date%");
                          }
                          
                          if (!empty($my_p_name)) {
                             $query->orWhere('my_p_name', 'LIKE', "%$my_p_name%");
                          }
                          
                          if (!empty($my_p_price)) {
                             $query->orWhere('my_p_price', 'LIKE', "%$my_p_price%");
                          }
                          
                          if (!empty($my_p_type)) {
                             $query->orWhere('my_p_type', 'LIKE', "%$my_p_type%");
                          }
                          
                          if (!empty($my_p_toppings)) {
                             $query->orWhere('my_p_toppings', 'LIKE', "%$my_p_toppings%");
                          }
                          
                          if (!empty($my_p_size)) {
                             $query->orWhere('my_p_size', 'LIKE', "%$my_p_size%");
                          }
                          
                        $listings = $query->orderBy("id", "desc")->get();
          
                  $listingsCount = $query->count();
          
                  $view = \View::make('pizza.pdf', compact('listings', 'listingsCount'));
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
          
          $pdf::SetTitle('بيتزا');
          $pdf::SetRTL(TRUE);
          $pdf::setMargins(5, 40, 5); //PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT
          $pdf::setHeaderMargin(5);
          $pdf::setFooterMargin(10);
          $pdf::setAutoPageBreak(TRUE, 25);
          $pdf::setImageScale(1.3);
      
          $pdf::AddPage();
          $pdf::SetFont('skyb', '', 10);
          $pdf::writeHTML($html_content, false, false, false, false, '');
          $pdf::Output('pizza_rep.pdf');
      }
      
                  
      
        

}
