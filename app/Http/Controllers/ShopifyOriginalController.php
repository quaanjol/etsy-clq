<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BsManagement;
use App\Models\BsOrderWong;
use App\Models\CvDs;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BsManagementExports;
use App\Exports\BsOrderWongExport;
use App\Exports\CvdsExport;

class ShopifyOriginalController extends Controller
{
    // show
    public function show() {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }
        $theme = $user->theme;
        $heading = ["vietnamese" => "Tạo file management", "english" => "Dashboard"];

        return view('admin.web.shopifyoriginal.convertCvDs')->with([
            'theme' => $theme,
            'user' => $user,
            'heading' => $heading,
        ]);
    }

    public function convertCanvasDsStore(Request $request) {
        $user = auth()->user();
        if($user == null) {
            return redirect('/login');
        }
        if($user->role == 'user') {
            return redirect('/');
        }

        $file = $request->file;
        $csv = array_map('str_getcsv', file($file));
        dd($csv);
        $cvdses = [];
        foreach($csv as $index => $row) {
            if($index == 0) {
                continue;
            }

            try {
                $prdDetail = $row[17];
                $design = trim(explode("-", $prdDetail)[0]);
                $type = trim(explode("-", $prdDetail)[1]);
                
                $prdName = $design . ' ' . $type;
                $quantityColumn = $row[16];
                $variationColumn = trim(explode("-", $prdDetail)[2]);
                
                if(strpos($prdName, "Bedding Set") == false) {
                    // dd($prdName);
                    $cvds = new CvDs();
                    $cvds->reference_id = $row[0];
                    $cvds->quantity = $quantityColumn;

                    // default resize 1 and position 1
                    $cvds->resize1 = "fill";
                    $cvds->position1 = "center_center";

                    // if(count(explode(": ", $variationColumn)) < 3) {
                    //     dd($variationColumn);
                    // }
                    $size = explode(": ", $variationColumn)[2];
                    // in case of canvas poster
                    if(strpos($prdName, "Wall Art Poster") !== false || strpos($prdName, "Poster Art") !== false) {
                        // dd($size);
                        if(strpos($size, "in") !== false) {
                            $size = str_replace("in", "", $size);
                            $cvds->print_area_key1 = $size;
                            if($size == "10x8") {
                                $cvds->item_variant_id = "1227";
                            } elseif ($size == "8x10") {
                                $cvds->item_variant_id = "1226";
                            } elseif ($size == "24x16") {
                                $cvds->item_variant_id = "4333";
                            } elseif ($size == "16x24") {
                                $cvds->item_variant_id = "4329";
                            } elseif ($size == "40x27") {
                                $cvds->item_variant_id = "4339";
                            } elseif ($size == "27x40") {
                                $cvds->item_variant_id = "4336";
                            }
                        }
                    }

                    // in case of canvas blanket
                    if(strpos($prdName, "Blanket") !== false) {
                        $cvds->print_area_key1 = $size;
                        if($size == "30x40") {
                            $cvds->item_variant_id = "746";
                        } elseif ($size == "50x60") {
                            $cvds->item_variant_id = "747";
                        } elseif ($size == "60x80") {
                            $cvds->item_variant_id = "748";
                        }
                    }

                    // in case of canvas wall art 1P, 3P, 5P
                    if(strpos($prdName, "Canvas Wall Decor") !== false || strpos($prdName, "Canvas Art Print") !== false) {
                        // dd($variationColumn);
                        if(strpos($size, " ") !== false) {
                            $panel = explode(" ", $size)[0];
                            $size = str_replace(",", "", explode(" ", $size)[1]);

                            $customOrNot = '';
                            $customMsg = '';
                            $customPosition = '';

                            // dd($panel . ' ' . $size);

                            if(strpos($variationColumn, "Want to add a gift message onto your wall art?") !== false) {
                                $customOrNot = explode(", ", explode(": ", $variationColumn)[3])[0];
                                if(isset(explode(": ", $variationColumn)[4])) {
                                    $customMsg = explode(", ", explode(": ", $variationColumn)[4])[0];
                                }

                                if(isset(explode(": ", $variationColumn)[4])) {
                                    if(isset(explode(": ", $variationColumn)[5])) {
                                        $customPosition = explode(": ", $variationColumn)[5];
                                    }
                                }
                                
                                $cvds->test_order = "Custom: " . $customOrNot . ', Message: ' . $customMsg . ', Position: ' . $customPosition;
                            }
    
                            if ($panel == "1P") {
                                $cvds->print_area_key1 = $size;
                                if($size == "10x8") {
                                    $cvds->item_variant_id = "750";
                                } elseif ($size == "24x16") {
                                    $cvds->item_variant_id = "758";
                                } elseif ($size == "36x24") {
                                    $cvds->item_variant_id = "760";
                                } elseif ($size == "48x32") {
                                    $cvds->item_variant_id = "762";
                                }
                            } elseif ($panel == "3P") {
                                $cvds->resize2 = "fill";
                                $cvds->position2 = "center_center";
                                $cvds->resize3 = "fill";
                                $cvds->position3 = "center_center";

                                if ($size == "38x18") {
                                    $cvds->print_area_key1 = "1_12x18";
                                    $cvds->print_area_key2 = "2_12x18";
                                    $cvds->print_area_key3 = "3_12x18";
                                    $cvds->item_variant_id = "3375";
                                } elseif ($size == "50x24") {
                                    $cvds->print_area_key1 = "1_16x24";
                                    $cvds->print_area_key2 = "2_16x24";
                                    $cvds->print_area_key3 = "3_16x24";
                                    $cvds->item_variant_id = "3376";
                                }
                            } elseif ($panel == "5P") {
                                $cvds->resize2 = "fill";
                                $cvds->position2 = "center_center";
                                $cvds->resize3 = "fill";
                                $cvds->position3 = "center_center";
                                $cvds->resize4 = "fill";
                                $cvds->position4 = "center_center";
                                $cvds->resize5 = "fill";
                                $cvds->position5 = "center_center";

                                if ($size == "64x32") {
                                    $cvds->print_area_key1 = "1_12x16";
                                    $cvds->print_area_key2 = "2_12x16";
                                    $cvds->print_area_key3 = "3_12x24";
                                    $cvds->print_area_key4 = "4_12x24";
                                    $cvds->print_area_key5 = "5_12x32";
                                    $cvds->item_variant_id = "3378";
                                } elseif ($size == "64x36") {
                                    $cvds->print_area_key1 = "1_12x36";
                                    $cvds->print_area_key2 = "2_12x36";
                                    $cvds->print_area_key3 = "3_12x36";
                                    $cvds->print_area_key4 = "4_12x36";
                                    $cvds->print_area_key5 = "5_12x36";
                                    $cvds->item_variant_id = "3379";
                                } elseif ($size == "84x40") {
                                    $cvds->print_area_key1 = "1_16x24";
                                    $cvds->print_area_key2 = "2_16x24";
                                    $cvds->print_area_key3 = "3_16x32";
                                    $cvds->print_area_key4 = "4_16x32";
                                    $cvds->print_area_key5 = "5_16x40";
                                    $cvds->item_variant_id = "3377";
                                } elseif ($size == "84x48") {
                                    $cvds->print_area_key1 = "1_16x48";
                                    $cvds->print_area_key2 = "2_16x48";
                                    $cvds->print_area_key3 = "3_16x48";
                                    $cvds->print_area_key4 = "4_16x48";
                                    $cvds->print_area_key5 = "5_16x48";
                                    $cvds->item_variant_id = "3380";
                                }
                            }
    
                        }
                    }

                    // dd('vid ' .  $cvds->item_variant_id);
                    $cvds->first_name = $row[18];
                    $cvds->last_name = $row[19];
                    $cvds->street1 = $row[21];
                    $cvds->street2 = $row[22];
                    $cvds->city = $row[23];
                    $cvds->state = $row[24];
                    $cvds->country = $row[27];
                    $cvds->zip = $row[26];
                    if(strpos($row[29], "+") !== false) {
                        $cvds->phone = "'" . str_replace("+", "", $row[29]);
                    } else {
                        $cvds->phone = "'" . $row[29];
                    }
                    $cvdses[] = $cvds;
                }

            } catch (Exception $e) {

            }

        }

        // dd($bsManagements);
        $collection = new Collection();
        foreach($cvdses as $cvds){
            $collection->push((object)[
                'reference_id' => $cvds->reference_id,
                'quantity' => $cvds->quantity,
                'item_variant_id' => $cvds->item_variant_id,
                'first_name' => $cvds->first_name,
                'last_name' => $cvds->last_name,
                'street1' => $cvds->street1,
                'street2' => $cvds->street2,
                'city' => $cvds->city,
                'state' => $cvds->state,
                'country' => $cvds->country,
                'zip' => $cvds->zip,
                'phone' => $cvds->phone,
                'force_verified_delivery' => $cvds->force_verified_delivery,
                'print_area_key1' => $cvds->print_area_key1,
                'artwork_url1' => $cvds->artwork_url1,
                'resize1' => $cvds->resize1,
                'position1' => $cvds->position1,
                'print_area_key2' => $cvds->print_area_key2,
                'artwork_url2' => $cvds->artwork_url2,
                'resize2' => $cvds->resize2,
                'position2' => $cvds->position2,
                'print_area_key3' => $cvds->print_area_key3,
                'artwork_url3' => $cvds->artwork_url3,
                'resize3' => $cvds->resize3,
                'position3' => $cvds->position3,
                'print_area_key4' => $cvds->print_area_key4,
                'artwork_url4' => $cvds->artwork_url4,
                'resize4' => $cvds->resize4,
                'position4' => $cvds->position4,
                'print_area_key5' => $cvds->print_area_key5,
                'artwork_url5' => $cvds->artwork_url5,
                'resize5' => $cvds->resize5,
                'position5' => $cvds->position5,
                'test_order' => $cvds->test_order,
            ]);

        }
        
        // dd($bsManagements[0]);
        $excelArray = [];
        foreach($collection as $csdv) {
            $tmp = [];
            foreach($csdv as $key => $value) {
                $tmp[$key] = $value;
            }
            // $excelArray[] = $tmp;
            array_push($excelArray, $tmp);
        }
        // dd($excelArray);
        return Excel::download(new CvdsExport($excelArray), 'canvas-management.csv');
    }
}
