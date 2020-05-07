<table>
    <thead>
        <tr>
            <th>reference</th>
            <th>client</th>
            <th>departement</th>
            <th>agence</th>
            <th>produit</th>
            <th>equipement</th>
            <th>nombre de réclamation</th>
            <th>nombre de en cours</th>
            <th>nombre de en traitement</th>
            <th>nombre de clôturé</th>
            <th>Moyenne en cours</th>
            <th>Moyenne en traitement</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data['reference'] as $result)
        <tr>
            <td>{{ $result->equip_ref }} </td>
            <td>{{ $result->client_nom }} </td>
            <td>{{ $result->depart_nom }} </td>
            <td>{{ $result->agence_nom }} </td>
            <td>{{ $result->prod_nom }} </td>
            <td>{{ $result->equip_nom }} </td>
            <td> {{ $result->nb_reclamation }}</td>
            <td> {{ $result->nb_created }}</td>
            <td> {{ $result->nb_pending }}</td>
            <td> {{ $result->nb_closed }}</td>
            <td> {{ is_null($result->avg_created_time) ? 'N/A' : seconds2human($result->avg_created_time)   }}</td>
            <td> {{ is_null($result->avg_pending_time) ? 'N/A' :  seconds2human($result->avg_pending_time) }}</td>
        </tr>
        @endforeach
        @foreach($data['total_reference'] as $result)
        <tr>
            <td> total</td>
            <td> N/A</td>
            <th>N/A</th>
            <th>N/A</th>
            <th>N/A</th>
            <th>N/A</th>
            <td> {{ $result->nb_reclamation }}</td>
            <td> {{ $result->nb_created }}</td>
            <td> {{ $result->nb_pending }}</td>
            <td> {{ $result->nb_closed }}</td>
            <td> {{ is_null($result->avg_created_time) ? 'N/A' : seconds2human($result->avg_created_time)   }}</td>
            <td> {{ is_null($result->avg_pending_time) ? 'N/A' :  seconds2human($result->avg_pending_time) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<?php
function seconds2human($ss) {
    $s = $ss%60;
    $m = floor(($ss%3600)/60);
    $h = floor(($ss%86400)/3600);
    $d = floor(($ss%2592000)/86400);
    $M = floor($ss/2592000);
        
    return "$M mois, $d j, $h h, $m min, $s sec";
}
