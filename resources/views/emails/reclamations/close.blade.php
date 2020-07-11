@component('mail::message')
Bonjour <b>User</b> 

On vous informe que la réclamation avec les informations si-dessous est <b>clôturé</b>

@component('mail::table')
    | Champ       | information         |
    | ------------- |:-------------:| 
    | <b>réference</b>      | 5346543154654654      | 
    | <b>agence</b>      | agence lfath | 
    | <b>Produit</b>       | system de surveillance | 
    | <b>Anomalie</b>       | anomalie-1 | 
    | <b>Technicien</b>       | tech hamid | 
    | <b>en traitement le</b>        |  2020-05-02 19:22:33 |
    | <b>terminé le</b>        |  2020-07-02 19:22:33 |  
@endcomponent
@component('mail::button', ['url' => 'http://127.0.0.1:8000/dashboard/reclamations/detail/ref/2020-R1593717753-55','color' => 'success','style' => 'width:33%;float:left'])
détails
@endcomponent
@component('mail::button', ['url' => 'http://127.0.0.1:8000/dashboard/reclamations/detail/ref/2020-R1593717753-55','color' => 'warning','style' => 'width:33%;float:left'])
pv pending
@endcomponent
@component('mail::button', ['url' => 'http://127.0.0.1:8000/dashboard/reclamations/detail/ref/2020-R1593717753-55','color' => 'error','style' => 'width:33%;float:left'])
pv closed
@endcomponent


à bientôt <br>
Assistance {{ config('app.name') }}
@endcomponent