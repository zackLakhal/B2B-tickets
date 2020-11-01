<?php

use App\Client;
use App\Departement;
use App\Agence;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', function () {
    //Artisan::call('config:cache');
    return view('old_nst.index');
});

Route::get('/about', function () {
    return view('old_nst.about');
});
Route::get('/clients', function () {
    return view('old_nst.clients');
});
Route::get('/contacts', function () {
    return view('old_nst.contacts');
});
Route::get('/projects', function () {
    return view('old_nst.projects');
});
Route::get('/services', function () {
    return view('old_nst.services');
});
Route::get('/send', 'RequestController@sendmail');


Auth::routes();


Route::get('/client-login', function () {
    return view('auth.client_login');
});
Route::post('/client-login', 'Auth\ClientLoginController@login')->name('client.login');

Route::get('/nst-login', function () {
    return view('auth.nst_login');
});
Route::post('/nst-login', 'Auth\NstLoginController@login')->name('nst.login');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/client-home', 'HomeClientController@index')->middleware('auth:client')->name('client');
Route::get('/nst-home', 'HomeNstController@index')->middleware('auth:nst,client')->name('nst');


Route::prefix('/statistiques')->group(function () {
    Route::get('/index', 'StatiqtiqueController@index');
    Route::get('/export_stat', 'StatiqtiqueController@export_stat');
    Route::get('/print_pv', 'StatiqtiqueController@print');
    Route::post('/filter_index', 'StatiqtiqueController@filter_index');
    Route::get('/fill_list', 'StatiqtiqueController@fill_list');
    Route::post('/filter_data', 'StatiqtiqueController@filter_data');
    Route::get('/', function () {
        return view('statistique.index');
    })->middleware('auth:nst,client');
});

Route::get('/dashboard', function () {
    return view('statistique.dashboard');
})->middleware('auth:nst,client');


Route::get('/dashboard_agence', function () {
    return view('statistique.dashboard_agence');
})->middleware('auth:nst,client');

Route::get('/dashboard/reclamations/detail/{type}/{value}', function ($type, $value) {
    return view('statistique.detail', ['type' => $type, 'value' => $value]);
})->middleware('auth:nst,client');

Route::get('/dashboard/agence_dash', 'ReclamationController@agence_dash')->middleware('auth:nst,client');
Route::post('/dashboard/filter_agence_dash', 'ReclamationController@filter_agence_dash')->middleware('auth:nst,client');


Route::prefix('/system')->group(function () {
    Route::prefix('/role')->group(function () {

        Route::get('/index', 'RoleController@index');
        Route::get('/active_index', 'RoleController@active_index');
        Route::post('/{edit}/{id}', 'RoleController@edit');
        Route::post('/create', 'RoleController@store');
        Route::get('/', function () {
            return view('system.role');
        })->middleware('auth:nst,client');
    });
    Route::prefix('/ville')->group(function () {

        Route::get('/index', 'VilleController@index');
        Route::get('/active_index', 'VilleController@active_index');
        Route::post('/{edit}/{id}', 'VilleController@edit');
        Route::post('/create', 'VilleController@store');
        Route::get('/', function () {
            return view('system.ville');
        })->middleware('auth:nst,client');
    });

    Route::prefix('/request')->group(function () {

        Route::get('/index', 'RequestController@index')->middleware('auth:nst,client');
        Route::post('/filter_index', 'RequestController@filter_index')->middleware('auth:nst,client');
        Route::post('/store', 'RequestController@store');
        Route::get('/detail/{id}', 'RequestController@detail')->middleware('auth:nst,client');
        Route::get('/traiter/{id}', 'RequestController@traiter')->middleware('auth:nst,client');
        Route::get('/', function () {
            return view('system.requete');
        })->middleware('auth:nst,client');
    });
});

Route::prefix('/reclamation')->group(function () {
    Route::prefix('/etat')->group(function () {
        Route::get('/index', 'EtatController@index');
        Route::post('/{edit}/{id}', 'EtatController@edit');
        Route::post('/create', 'EtatController@store');
        Route::get('/', function () {
            return view('reclamation.etat');
        })->middleware('auth:nst,client');
    });

    Route::prefix('/anomalie')->group(function () {

        Route::get('/index', 'AnomalieController@index');
        Route::get('/active_index', 'AnomalieController@non_deleted');
        Route::post('/{edit}/{id}', 'AnomalieController@edit');
        Route::post('/create', 'AnomalieController@store');
        Route::get('/', function () {
            return view('reclamation.anomalie');
        })->middleware('auth:nst,client');
    });

    Route::prefix('/recls')->group(function () {
        Route::get('/index', 'ReclamationController@index');
        Route::post('/filter_index', 'ReclamationController@filter_index');
        Route::get('/fill_list', 'ReclamationController@fill_list');
        Route::post('/filter_data', 'ReclamationController@filter_data');
        Route::get('/get_techniciens/{us_id}', 'ReclamationController@get_techniciens');
        Route::get('/get_reclamation', 'ReclamationController@get_reclamation');
        Route::get('/get_rapport', 'ReclamationController@get_rapport');
        Route::post('/set_techniciens', 'ReclamationController@set_techniciens');
        Route::post('/accepter', 'ReclamationController@accepter');
        Route::post('/save_raport', 'ReclamationController@save_raport');
        Route::post('/edit_raport', 'ReclamationController@edit_raport');
        Route::get('/{edit}/{id}', 'ReclamationController@edit');
        Route::get('/create', 'ReclamationController@store');
        Route::get('/', function () {
            return view('reclamation.recls');
        })->middleware('auth:nst,client');
    });
});

Route::prefix('/utilisateur')->group(function () {
    Route::prefix('/profile')->group(function () {
        Route::get('/', function () {
            return view('utilisateurs.profiles.nst_profile');
        })->middleware('auth:nst,client');
        Route::get('/index', 'UserController@profile_index');
    });
    Route::prefix('/staff-client')->group(function () {

        Route::get('/index', 'UserController@client_index');
        Route::post('/filter_index', 'UserController@filter_client_index');
        Route::get('/{id_c}/my_users_departement', 'UserController@my_users_departement');
        Route::get('/{id_c}/my_users_agence', 'UserController@my_users_agence');
        Route::post('/{edit}/{id}', 'UserController@client_edit');
        Route::post('/create', 'UserController@client_store');
        Route::post('/save_pass', 'UserController@save_pass');
        Route::get('/', function () {
            return view('utilisateurs.client.staff-client');
        })->middleware('auth:nst,client');
    });

    Route::prefix('/staff-nst')->group(function () {

        Route::get('/index', 'UserController@nst_index');
        Route::post('/filter_index', 'UserController@filter_nst_index');
        Route::post('/{edit}/{id}', 'UserController@nst_edit');
        Route::post('/create', 'UserController@nst_store');
        Route::get('/', function () {
            return view('utilisateurs.staff.staff-nst');
        })->middleware('auth:nst,client');
    });
});


Route::prefix('/outils')->group(function () {
    Route::prefix('/clients')->group(function () {

        Route::get('/index', 'ClientController@all_clients');
        Route::post('/filter_index', 'ClientController@filter_all_clients');
        Route::get('/active_index', 'ClientController@active_clients');
        Route::post('/edit/{id_c}', 'ClientController@edit_client');
        Route::post('/delete/{id_c}', 'ClientController@delete_client');
        Route::post('/restore/{id_c}', 'ClientController@restore_client');
        Route::post('/create', 'ClientController@store_client');
        Route::get('/', function () {
            return view('tools.clients');
        })->middleware('auth:nst,client');

        Route::prefix('{id_c}/departements')->group(function () {

            Route::get('/index', 'ClientController@all_departements');
            Route::post('/filter_index', 'ClientController@filter_all_departements');
            Route::get('/affecter', 'ClientController@affecter');
            Route::post('/edit/{id_d}', 'ClientController@edit_departement');
            Route::post('/delete/{id_d}', 'ClientController@delete_departement');
            Route::post('/restore/{id_d}', 'ClientController@restore_departement');
            Route::post('/create', 'ClientController@store_departement');
            Route::get('/', function ($id_c) {

                return view('tools.departements', ['client' => Client::find($id_c)]);
            })->middleware('auth:nst,client');

            Route::prefix('{id_d}/agences')->group(function () {

                Route::get('/index', 'ClientController@all_agences');
                Route::post('/filter_index', 'ClientController@filter_all_agences');
                Route::post('/edit/{id_a}', 'ClientController@edit_agence');
                Route::post('/delete/{id_a}', 'ClientController@delete_agence');
                Route::post('/restore/{id_a}', 'ClientController@restore_agence');
                Route::post('/create', 'ClientController@store_agence');
                Route::get('/affecter', 'ClientController@affecter_agence');
                Route::get('/', function ($id_c, $id_d) {
                    return view('tools.agences', ['departement' => Departement::find($id_d)]);
                })->middleware('auth:nst,client');
            });
        });
    });


    Route::prefix('/produits')->group(function () {

        Route::get('/index', 'ProduitController@index');
        Route::post('/filter_index', 'ProduitController@filter_index');
        Route::get('/equip_prod', 'ProduitController@equip_prod');
        Route::post('/attach_prod', 'ProduitController@attach_prod');
        Route::get('/detach_prod', 'ProduitController@detach_prod');
        Route::get('/active_index', 'ProduitController@active_produits');
        Route::post('/save_ref', 'ProduitController@save_ref');
        Route::get('/delete_ref', 'ProduitController@delete_ref');
        Route::post('/edit/{id_c}', 'ProduitController@edit_produit');
        Route::post('/delete/{id_c}', 'ProduitController@delete_produit');
        Route::post('/restore/{id_c}', 'ProduitController@restore_produit');
        Route::post('/create', 'ProduitController@store_produit');

        Route::get('/', function () {
            return view('tools.produits');
        })->middleware('auth:nst,client');
        Route::prefix('{id_p}/equipements')->group(function () {
            Route::get('/index', 'ProduitController@index_equipement');
            Route::post('/edit/{id_a}', 'ProduitController@edit_equipement');
            Route::post('/delete/{id_a}', 'ProduitController@delete_equipement');
            Route::post('/restore/{id_a}', 'ProduitController@restore_equipement');
            Route::post('/create', 'ProduitController@store_equipement');
        });
    });

    Route::prefix('espace-client')->group(function () {
        Route::get('/', function () {
            return view('tools.espace.index');
        })->middleware('auth:nst,client');
        Route::get('/agence/{id}', function ($id) {
            $agence = Agence::find($id);
            return view('tools.espace.agence', ['agence' => $agence]);
        })->middleware('auth:nst,client');
        Route::get('/index', 'EspaceController@all_agences');
        Route::get('/agence/{id}/detail', 'EspaceController@detail_agence');
        Route::get('/agence/{id_a}/get_equipements/{id_p}', 'EspaceController@get_equipements');
        Route::get('/agence/{id_a}/get_refs', 'EspaceController@get_refs');
        Route::post('/agence/{id_a}/reclamer', 'EspaceController@add_reclamation');
    });
    Route::prefix('espace-agence')->group(function () {
        Route::get('/', function () {
            return view('tools.espace.new_espace');
        })->middleware('auth:nst,client');
    });
});
