@component('mail::message')
Bonjour <b>User</b> 

On vous informe qu'une nouvelle réclamation vous a été affecté et en attente d'acceptation avec les informations suivantes 

@component('mail::table')
    | Champ       | information         |
    | ------------- |:-------------:| 
    | <b>réference</b>      | 5346543154654654      | 
    | <b>agence</b>      | agence lfath | 
    | <b>Produit</b>       | system de surveillance | 
    | <b>Anomalie</b>       | anomalie-1 | 
    | <b>Affecté le</b>        |  2020-07-02 19:22:33 | 
@endcomponent


@component('mail::button', ['url' => 'http://127.0.0.1:8000/dashboard/reclamations/detail/ref/2020-R1593717753-55'])
Voir plus de détails
@endcomponent

à bientôt <br>
Assistance {{ config('app.name') }}
@endcomponent
