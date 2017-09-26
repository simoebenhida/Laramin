<td>
            @if($infos == 'PUBLISHED')
            <span class="tag is-success">PUBLISHED</span>
            @else
            @if($infos == 'PENDING')
            <span class="tag is-warning">PENDING</span>
            @else
            @if($infos == 'DRAFT')
            <span class="tag is-danger">DRAFT</span>
            @endif
            @endif
            @endif
</td>
