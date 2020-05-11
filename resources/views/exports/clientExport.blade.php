<table>
    <thead>
        <tr>
            <td colspan="7"> statistique {{$data['date']}} </td>
        </tr>
        <tr>
            <th>client</th>
            <th>nombre de réclamation</th>
            <th>nombre de en cours</th>
            <th>nombre de en traitement</th>
            <th>nombre de clôturé</th>
            <th>Moyenne en cours</th>
            <th>Moyenne en traitement</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data['client'] as $result)
        <tr>
            <td> {{ $result->client_nom }}</td>
            <td> {{ $result->nb_reclamation }}</td>
            <td> {{ $result->nb_created }}</td>
            <td> {{ $result->nb_pending }}</td>
            <td> {{ $result->nb_closed }}</td>
            <td> {{ is_null($result->avg_created_time) ? 'N/A' : seconds2human($result->avg_created_time)   }}</td>
            <td> {{ is_null($result->avg_pending_time) ? 'N/A' :  seconds2human($result->avg_pending_time) }}</td>
        </tr>
        @endforeach
        @foreach($data['total_client'] as $result)
        <tr>
            <td> total</td>
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
function seconds2human($ss)
{
    $s = $ss % 60;
    $m = floor(($ss % 3600) / 60);
    $h = floor(($ss % 86400) / 3600);
    $d = floor(($ss % 2592000) / 86400);
    $M = floor($ss / 2592000);

    return "$M mois, $d j, $h h, $m min, $s sec";
}
