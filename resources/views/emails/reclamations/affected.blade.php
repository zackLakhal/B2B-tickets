@component('mail::message')
Bonjour <b> {{$user}} </b>

On vous informe qu'une nouvelle réclamation vous a été affecté et en attente d'acceptation avec les informations suivantes 

@component('mail::table')
| Champ       | information         |
    | ------------- |:-------------:| 
    | <b>réference</b>      | {{$ref}}      | 
    | <b>agence</b>      | {{$agence}} | 
    | <b>Produit</b>       | {{$prod}} | 
    | <b>Anomalie</b>       | {{$anomalie}} | 
    | <b>Affecté le</b>        |  {{$affected_at}} | 
@endcomponent


@component('mail::button', ['url' => 'http://127.0.0.1:8000/dashboard/reclamations/detail/ref/'.$ref,'color' => 'success','style' => 'width:100%'])
Voir plus de détails
@endcomponent

à bientôt <br>
Assistance {{ config('app.name') }}
@endcomponent
