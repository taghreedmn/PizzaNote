<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Alkoumi\LaravelHijriDate\Hijri;
use Elibyy\TCPDF\Facades\TCPDF;
use App\Models\Order;
use App\Models\Favorite;
use App\Models\Pizza;
class Order_cnt extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function create(Request $request)
    { 
    
        return view('orders.create');
    }

    public function store(Request $request)
      {
          //if u need uniqe add in array 'unique:'Table::class
          //if u need null add in array nullable
          $request->validate([
            'user_id' => ['integer' , 'nullable',],
            'pizza_id' => ['integer' , 'nullable',],          
            'order_date' => ['string', 'max:55'  ,'nullable' ],
              'user_name' => ['string', 'max:255' , 'nullable', ],
              'pizza_name' => ['string', 'max:255' , 'required', ],
              'pizza_size'=> ['string', 'max:255' , 'required', ],
              'pizza_type'=> ['string', 'max:255' , 'required', ],
              'price' => ['integer' , 'nullable',],
              'toppings' => 'nullable',
              'order_status'=> ['integer', 'nullable'],
              'notes' => 'nullable',


                  
              ]);
              
              
              
              $txt_para = '';
  
              if ($request->has('toppings')) {
                  $txt_para = implode(',', $request->input('toppings'));
                  $txt_para = rtrim($txt_para, ',');
              }

                $order = new Order();

                  $order->user_id = $request->input('user_id');

                   $order->order_date = $request->input('order_date');
                   
                   $order->user_name = $request->input('user_name');

                   $order->pizza_name = $request->input('pizza_name');

                   $order->pizza_size = $request->input('pizza_size');

                   $order->pizza_type = $request->input('pizza_type');

                   $order -> toppings= $txt_para;
                   
                   $order-> notes = $request->input('notes');
                    
                    $pizza = Pizza::all();
                   
                  foreach ($pizza as $key ) {
                      if ($order->pizza_name == $key->my_p_name) {
                          $order -> pizza_id = $key->id;
                          $order->price = $key->my_p_price;
                      }
                    }
                    

                 $order->order_log = set_reg_stamp('إضافة');
              $order->save();

              //return redirect()->route('myfrind.index');
              return response()->json('2');
            }
            
    public function show(string $id)
        {
            $id = dec($id);
            return view('orders.show',[
                'listings' => Order::findOrFail($id)
            ]);
        }
        
    public function edit(string $id)
        {
          $id = dec($id);
          return view('orders.edit',[
              'listings' => Order::findOrFail($id)
          ]);
        
    
        }

        

    public function update(Request $request)
        {
          $order = Order::findOrFail(dec(request()->input('id')));
          $request->validate([
            'pizza_id' => ['integer' , 'nullable',],          
              'pizza_name' => ['string', 'max:255' , 'required', ],
              'pizza_size'=> ['string', 'max:255' , 'required', ],
              'pizza_type'=> ['string', 'max:255' , 'required', ],
              'toppings' => 'nullable',
              'notes' => 'nullable',
                        
                ]);

                if ($request->has('toppings') and $request->input('toppings')!= $order->toppings) {
                    $txt_para = '';
                    $txt_para = implode(',', $request->input('toppings'));
                    $txt_para = rtrim($txt_para, ',');
                }else{
                    $txt_para = $order->toppings;
                }

              $order->pizza_name = $request->input('pizza_name');

              $order->pizza_size = $request->input('pizza_size');

              $order->pizza_type = $request->input('pizza_type');

              $order -> toppings= $txt_para;
              
              $order-> notes = $request->input('notes');
               
               $pizza = Pizza::all();
              
             foreach ($pizza as $key ) {
                 if ($order->pizza_name == $key->my_p_name) {
                     $order -> pizza_id = $key->id;
                     $order->price = $key->my_p_price;
                 }
               }
               

              // $order->order_log .= set_reg_stamp('تحديث');
              $order->order_log .= set_reg_stamp('تحديث');
            $order->save();
            //return redirect()->route('myfrind.index');
            return response()->json('2');
            }

    public function destroy(string $id)
          {
            $idx= dec($id);
            $delx = Order::findOrFail($idx);
            $delx->delete();
            return response()->json('2');
          }

    public function list(Request $request)
      {
          $query = $request->input('q');
      
          if (!empty($query)) {
              $listings = Order::
              where('id', 'LIKE', "%$query%")
              ->orWhere('user_id', 'LIKE', "%$query%")
              ->orWhere('pizza_id', 'LIKE', "%$query%")
        ->orWhere('order_date', 'LIKE', "%$query%")
                ->orWhere('user_name', 'LIKE', "%$query%")
                ->orWhere('pizza_name', 'LIKE', "%$query%")
                ->orWhere('pizza_size', 'LIKE', "%$query%")
                ->orWhere('pizza_type', 'LIKE', "%$query%")
                ->orWhere('price', 'LIKE', "%$query%")
                ->orWhere('toppings', 'LIKE', "%$query%")
                ->orWhere('order_status', 'LIKE', "%$query%")
                ->orWhere('notes', 'LIKE', "%$query%")
            
                
                      ->orderBy("id", "desc")
                      ->paginate(20);
          } else {
              $listings = Order::orderBy("id", "desc")->paginate(20);
          }
      
          return view('orders.list', compact('listings'));
        }
      
    public function rep()
      {
          return view('orders.rep');
      }

    public function rep_excel(Request $request)
      {
        

        $order_date = $request->input('order_date');

        $pizza_name = $request->input('pizza_name');

        $pizza_size = $request->input('pizza_size');

        $pizza_type = $request->input('pizza_type');

        $price = $request->input('price');

              $query = Order::query();
              
                    if (!empty($order_date)) {
                       $query->orWhere('order_date', 'LIKE', "%$order_date%");
                    }
                    
                    if (!empty($pizza_name)) {
                       $query->orWhere('pizza_name', 'LIKE', "%$pizza_name%");
                    }
                    
                    if (!empty($pizza_size)) {
                       $query->orWhere('pizza_size', 'LIKE', "%$pizza_size%");
                    }
                    
                    if (!empty($pizza_type)) {
                       $query->orWhere('pizza_type', 'LIKE', "%$pizza_type%");
                    }
                    
                    if (!empty($price)) {
                      $query->orWhere('price', 'LIKE', "%$price%");
                   }
                    
                      $listings = $query->orderBy("id", "desc")->get();
                      $listingsCount = $query->count();
  
                  return view('orders.excel', compact('listings', 'listingsCount'));
      }
      
     public function rep_pdf(Request $request)
            {
              $order_date= $request->input('order_date');
              $pizza_name= $request->input('pizza_name');
              $pizza_size= $request->input('pizza_size');
              $pizza_type= $request->input('pizza_type');
              $price= $request->input('price');
              
              
        $query = Order::query();
        
              if (!empty($order_date)) {
                 $query->orWhere('order_date', 'LIKE', "%$order_date%");
              }
              
              if (!empty($pizza_name)) {
                 $query->orWhere('pizza_name', 'LIKE', "%$pizza_name%");
              }
              
              if (!empty($pizza_size)) {
                 $query->orWhere('pizza_size', 'LIKE', "%$pizza_size%");
              }
              
              if (!empty($pizza_type)) {
                 $query->orWhere('pizza_type', 'LIKE', "%$pizza_type%");
              }
              if (!empty($price)) {
                $query->orWhere('price', 'LIKE', "%$price%");
             }
                          
                        $listings = $query->orderBy("id", "desc")->get();
          
                  $listingsCount = $query->count();
          
                  $view = \View::make('orders.pdf', compact('listings', 'listingsCount'));
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
          
          $pdf::SetTitle('طلباتي');
          $pdf::SetRTL(TRUE);
          $pdf::setMargins(5, 40, 5); //PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT
          $pdf::setHeaderMargin(5);
          $pdf::setFooterMargin(10);
          $pdf::setAutoPageBreak(TRUE, 25);
          $pdf::setImageScale(1.3);
      
          $pdf::AddPage();
          $pdf::SetFont('skyb', '', 10);
          $pdf::writeHTML($html_content, false, false, false, false, '');
          $pdf::Output('orders_rep.pdf');
      }
      
                  
      
        

}
