<table>
    <thead>
        <tr>
            <th colspan="4" style="text-align: center; font-weight: bold;">Grinding Inventory</th>
        </tr>
        <tr>
            <th style="text-align: center; font-weight: bold; border: 1px solid black;">Parts Code</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid black;">Parts Name</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid black;">Allocation</th>
            <th style="text-align: center; font-weight: bold; border: 1px solid black;">Qty</th>
            {{-- <th>Eoh</th> --}}
            {{-- <th>remarks</th> --}}
        </tr>
    </thead>
    <tbody>
       @php
           $calc = 0;
       @endphp

       
        @for ($i = 0; $i < count($get_basemoldwip); $i++)
            <tr>
				
				<td style="text-align: center; border: 1px solid black; font-size: 12rem;" >{{ $get_basemoldwip[$i]->basemold->code }}</td>
				<td style="text-align: center; border: 1px solid black;font-size: 12rem;">{{ $get_basemoldwip[$i]->basemold->part_name }}</td>
                <td style="text-align: center; border: 1px solid black;font-size: 12rem;">For Set-up</td>
				<td style="text-align: center; border: 1px solid black;font-size: 12rem;">{{ $get_basemoldwip[$i]->EOH }}</td>
                {{-- <td>{{ $get_basemoldwip[$i]->PR_number }}</td> --}}
                @php
                    $calc = $calc + $get_basemoldwip[$i]->EOH ;
                @endphp

            </tr>
        @endfor

        @for ($y = 0; $y<count($get_rework_visual); $y++)
            <tr>
                <td style="text-align: center; border: 1px solid black;font-size: 12rem;">{{ $get_rework_visual[$y]->fgs_details->fgs_code }}</td>
                <td style="text-align: center; border: 1px solid black;font-size: 12rem;">{{ $get_rework_visual[$y]->fgs_details->fgs_name }}</td>
                <td style="text-align: center; border: 1px solid black;font-size: 12rem;">For Rework / Visual</td>
                <td style="text-align: center; border: 1px solid black;font-size: 12rem;">{{ $get_rework_visual[$y]->EOH }}</td>
                @php
                    $calc = $calc + $get_rework_visual[$y]->EOH ;
                @endphp
            </tr>
        @endfor


        @for ($x = 0; $x < count($get_fgs); $x++){
            <tr>
				
				<td style="text-align: center; border: 1px solid black;font-size: 12rem;" >{{ $get_fgs[$x]->fgs_details->fgs_code }}</td>
				<td style="text-align: center; border: 1px solid black;font-size: 12rem;">{{ $get_fgs[$x]->fgs_details->fgs_name }}</td>
                <td style="text-align: center; border: 1px solid black;font-size: 12rem;">For Buyoff</td>
				<td style="text-align: center; border: 1px solid black;font-size: 12rem;">{{ $get_fgs[$x]->EOH }}</td>
                @php
                    $calc = $calc + $get_fgs[$x]->EOH ;
                @endphp

            </tr>
        }
            
        @endfor
        <tr></tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: center; border-bottom: 1px solid black;">{{ $calc }}</td>
        </tr>
    </tbody>
</table>