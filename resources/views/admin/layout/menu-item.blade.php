<ul class="list-unstyled">
  @foreach ($menuInArray as $parent => $child)
      <li class="parent-item menu-list-item">
          {{ $parent }}
          <div class="">
              <button class="btn btn-sm btn-warning" onclick="openEditModal({{ $child[0] }})"><i class="bi bi-pencil-square"></i></button>
              <button class="btn btn-sm btn-danger" onclick="openHapusModal({{ $child[0] }})"><i class="bi bi-x"></i></button>
          </div>
      </li>
      @if (count($child[1]) != 0)
          @foreach ($child[1] as $parent2 => $child2)
              <ul class="child-ul">
                  <li class="child-group-label">{{ $parent2 }}</li>
                  <ul class="child-item-ul">
                      @foreach ($child2 as $item)
                          <li class="child-item menu-list-item">
                              {{ $item[1] }}
                              <div class="">
                                  <button class="btn btn-sm btn-warning" onclick="openEditModal({{ $item[0] }})"><i class="bi bi-pencil-square"></i></button>
                                  <button class="btn btn-sm btn-danger" onclick="openHapusModal({{ $item[0] }})"><i class="bi bi-x"></i></button>
                              </div>
                          </li>
                      @endforeach
                  </ul>
              </ul>
          @endforeach
      @endif
  @endforeach
</ul>