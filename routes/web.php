<?php
use App\Client;
use App\Departement;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/client-login', function () {
    return view('auth.client_login');
});
Route::get('/nst-login', function () {
    return view('auth.nst_login');
});

Route::post('/client-login','Auth\ClientLoginController@login' )->name('client.login');
Route::post('/nst-login','Auth\NstLoginController@login' )->name('nst.login');

Route::get('/client-home', 'HomeClientController@index')->middleware('auth:client')->name('client');

Route::get('/nst-home', 'HomeNstController@index')->middleware('auth:nst')->name('nst');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::prefix('/system')->group(function(){ 
    Route::prefix('/role')->group(function(){ 
      
        Route::get('/index', 'RoleController@index')->middleware('auth:nst');
        Route::get('/active_index', 'RoleController@active_index')->middleware('auth:nst');
        Route::get('/{edit}/{id}', 'RoleController@edit')->middleware('auth:nst');
        Route::get('/create', 'RoleController@store')->middleware('auth:nst');
        Route::get('/', function(){
            return view('system.role');
        })->middleware('auth:nst');
        
    });
    Route::prefix('/ville')->group(function(){ 
      
        Route::get('/index', 'VilleController@index')->middleware('auth:nst');
        Route::get('/active_index', 'VilleController@active_index')->middleware('auth:nst');
        Route::get('/{edit}/{id}', 'VilleController@edit')->middleware('auth:nst');
        Route::get('/create', 'VilleController@store')->middleware('auth:nst');
        Route::get('/', function(){
            return view('system.ville');
        })->middleware('auth:nst');
    //   Route::get('/active_index', 'RoleController@active_index')->middleware('auth');
        
    });

    Route::prefix('/request')->group(function(){ 
      
        Route::get('/index', 'RequestController@index')->middleware('auth:nst');
        Route::get('/detail/{id}', 'RequestController@detail')->middleware('auth:nst');
        Route::get('/traiter/{id}', 'RequestController@traiter')->middleware('auth:nst');
        Route::get('/', function(){
            return view('system.requete');
        })->middleware('auth:nst');
    //   Route::get('/active_index', 'RoleController@active_index')->middleware('auth');
        
    });

});

Route::prefix('/reclamation')->group(function(){ 
    Route::prefix('/etat')->group(function(){ 
        Route::get('/index', 'EtatController@index')->middleware('auth:nst');
        Route::get('/{edit}/{id}', 'EtatController@edit')->middleware('auth:nst');
        Route::get('/create', 'EtatController@store')->middleware('auth:nst');
        Route::get('/', function(){
            return view('reclamation.etat');
        })->middleware('auth:nst');
    });

    Route::prefix('/anomalie')->group(function(){ 
        
        Route::get('/index', 'AnomalieController@index')->middleware('auth:nst');
        Route::get('/{edit}/{id}', 'AnomalieController@edit')->middleware('auth:nst');
        Route::get('/create', 'AnomalieController@store')->middleware('auth:nst');
        Route::get('/', function(){
            return view('reclamation.anomalie');
        })->middleware('auth:nst');
    });
});

Route::prefix('/utilisateur')->group(function(){ 
    Route::prefix('/staff-client')->group(function(){ 
        
        Route::get('/index', 'UserController@client_index')->middleware('auth:nst');
        Route::get('/{id_c}/my_users', 'UserController@my_users')->middleware('auth:nst');
        Route::post('/{edit}/{id}', 'UserController@client_edit')->middleware('auth:nst');
        Route::post('/create', 'UserController@client_store')->middleware('auth:nst');
        Route::get('/', function(){
            return view('utilisateurs.client.staff-client');
        })->middleware('auth:nst');
    });

    Route::prefix('/staff-nst')->group(function(){ 
        
        Route::get('/index', 'UserController@nst_index')->middleware('auth:nst');
        Route::post('/{edit}/{id}', 'UserController@nst_edit')->middleware('auth:nst');
        Route::post('/create', 'UserController@nst_store')->middleware('auth:nst');
        Route::get('/', function(){
            return view('utilisateurs.staff.staff-nst');
        })->middleware('auth:nst');
    });
});


Route::prefix('/outils')->group(function(){ 
    Route::prefix('/clients')->group(function(){ 
        
        Route::get('/index', 'ClientController@all_clients')->middleware('auth:nst');
        Route::get('/active_index', 'ClientController@active_clients')->middleware('auth:nst');
        Route::post('/edit/{id_c}', 'ClientController@edit_client')->middleware('auth:nst');
        Route::post('/delete/{id_c}', 'ClientController@delete_client')->middleware('auth:nst');
        Route::post('/restore/{id_c}', 'ClientController@restore_client')->middleware('auth:nst');
        Route::post('/create', 'ClientController@store_client')->middleware('auth:nst');
        Route::get('/', function(){
            return view('tools.clients');
        })->middleware('auth:nst');

        Route::prefix('{id_c}/departements')->group(function(){ 
        
            Route::get('/index', 'ClientController@all_departements')->middleware('auth:nst');
            Route::get('/affecter', 'ClientController@affecter')->middleware('auth:nst');
            Route::get('/edit/{id_d}', 'ClientController@edit_departement')->middleware('auth:nst');
            Route::get('/delete/{id_d}', 'ClientController@delete_departement')->middleware('auth:nst');
            Route::get('/restore/{id_d}', 'ClientController@restore_departement')->middleware('auth:nst');            Route::get('/create', 'ClientController@store_departement')->middleware('auth:nst');
            Route::get('/', function($id_c){
                
                return view('tools.departements',['client' => Client::find($id_c)]);
            })->middleware('auth:nst');

            Route::prefix('{id_d}/agences')->group(function(){ 
        
                Route::get('/index', 'ClientController@all_agences')->middleware('auth:nst');
                Route::get('/edit/{id_a}', 'ClientController@edit_agence')->middleware('auth:nst');
                Route::get('/delete/{id_a}', 'ClientController@delete_agence')->middleware('auth:nst');
                Route::get('/restore/{id_a}', 'ClientController@restore_agence')->middleware('auth:nst');   
                Route::get('/create', 'ClientController@store_agence')->middleware('auth:nst');
                Route::get('/affecter', 'ClientController@affecter_agence')->middleware('auth:nst');
                Route::get('/', function($id_d){
                    return view('tools.agences',['departement' => Departement::find($id_d)]);
                })->middleware('auth:nst');
            });

        });
    });


    Route::prefix('/produits')->group(function(){ 
        
        Route::get('/index', 'ProduitController@index')->middleware('auth:nst');
        Route::get('/equip_prod', 'ProduitController@equip_prod')->middleware('auth:nst');
        Route::get('/attach_prod', 'ProduitController@attach_prod')->middleware('auth:nst');
        Route::get('/active_index', 'ProduitController@active_produits')->middleware('auth:nst');
        Route::post('/edit/{id_c}', 'ProduitController@edit_produit')->middleware('auth:nst');
        Route::post('/delete/{id_c}', 'ProduitController@delete_produit')->middleware('auth:nst');
        Route::post('/restore/{id_c}', 'ProduitController@restore_produit')->middleware('auth:nst');
        Route::post('/create', 'ProduitController@store_produit')->middleware('auth:nst');
        Route::get('/', function(){
            return view('tools.produits');
        })->middleware('auth:nst');
        Route::prefix('{id_p}/equipements')->group(function(){ 
            Route::get('/index', 'ProduitController@index_equipement')->middleware('auth:nst');
            Route::post('/edit/{id_a}', 'ProduitController@edit_equipement')->middleware('auth:nst');
            Route::post('/delete/{id_a}', 'ProduitController@delete_equipement')->middleware('auth:nst');
            Route::post('/restore/{id_a}', 'ProduitController@restore_equipement')->middleware('auth:nst');               
             Route::post('/create', 'ProduitController@store_equipement')->middleware('auth:nst');
           
        });
    });

   

});