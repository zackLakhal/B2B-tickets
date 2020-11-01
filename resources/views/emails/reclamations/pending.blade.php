@component('mail::message')
Bonjour <b>{{$user}}</b> 

On vous informe que la réclamation avec les informations ci-dessous est <b>en traitement</b>

@component('mail::table')
    | Champ       | information         |
    | ------------- |:-------------:| 
    | <b>réference</b>      | {{$ref}}      | 
    | <b>agence</b>      | {{$agence}} | 
    | <b>Produit</b>       | {{$prod}} | 
    | <b>Anomalie</b>       | {{$anomalie}} |
    | <b>technicien</b>       | {{$tech}} | 
    | <b>en traitement le</b>        |  {{$pending_at}} | 
@endcomponent

@if(!empty($pv))
@component('mail::button', ['url' => 'http://127.0.0.1:8000/dashboard/reclamations/detail/ref/'.$ref,'color' => 'success','style' => 'width:50%;float:left'])
voir plus de détails
@endcomponent

@component('mail::button', ['url' => 'http://127.0.0.1:8000/public/storage/'.$pv,'color' => 'warning','style' => 'width:50%;float:left'])
pv pending
@endcomponent
@else
@component('mail::button', ['url' => 'http://127.0.0.1:8000/dashboard/reclamations/detail/ref/'.$ref,'color' => 'success','style' => 'width:100%'])
voir plus de détails
@endcomponent
@endif

à bientôt <br>
Assistance {{ config('app.name') }}
@endcomponent
