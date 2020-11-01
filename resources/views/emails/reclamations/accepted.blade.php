@component('mail::message')
Bonjour <b>{{$user}}</b> 

On vous informe que la réclamation avec les informations ci-dessous a été prise en charge par le technicien <b>{{$tech}}</b>

@component('mail::table')
    | Champ       | information         |
    | ------------- |:-------------:| 
    | <b>réference</b>      | {{$ref}}      | 
    | <b>agence</b>      | {{$agence}} | 
    | <b>Produit</b>       | {{$prod}} | 
    | <b>Anomalie</b>       | {{$anomalie}} | 
    | <b>Affecté le</b>        |  {{$accepted_at}} | 
@endcomponent


@component('mail::button', ['url' => 'http://127.0.0.1:8000/dashboard/reclamations/detail/ref/'.$ref,'color' => 'success','style' => 'width:100%'])
Voir plus de détails
@endcomponent

à bientôt <br>
Assistance {{ config('app.name') }}
@endcomponent
