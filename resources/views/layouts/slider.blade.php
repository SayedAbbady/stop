<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
      <a class="sidebar-brand" href="{{url('/')}}">
        <span class="align-middle">{{ config('app.name', 'Laravel') }}</span>
      </a>

      <ul class="sidebar-nav">
        <li class="sidebar-header">
          Pages
        </li>

        @permission('display-dashboard')
        <li class="sidebar-item {{ (Request::path() == '/') ? 'active' : ''}}">
          <a class="sidebar-link" href="{{url('/')}}">
            <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">Dashboard</span>
          </a>
        </li>
        @endpermission

        @permission('category')
        <li class="sidebar-item {{ (\Str::contains(Request::path(),'categor')) ? 'active' : ''}}">
          <a href="#" data-bs-target="#pages" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
            <i class="align-middle" data-feather="archive"></i> <span class="align-middle">Categories</span>
          </a>
          <ul id="pages" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
            @permission('show-category')
            <li class="sidebar-item"><a class="sidebar-link" href="{{route('cat')}}">Show all Categories</a></li>
            @endpermission

            @permission('add-category')
            <li class="sidebar-item"><a class="sidebar-link" href="{{route('cat.add')}}">Add new Categories</a></li>
            @endpermission

          </ul>
        </li>
        @endpermission

        @permission('students')
        <li class="sidebar-item {{ (\Str::contains(Request::path(), 'students')) ? 'active' : ''}}">
          <a href="#" data-bs-target="#students" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
            <i class="align-middle" data-feather="award"></i> <span class="align-middle">Students</span>
          </a>
          <ul id="students" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
            @permission('old-version-students')
            <li class="sidebar-item"><a class="sidebar-link" href="{{route('students.index')}}">Show all (Old version)</a></li>
            @endpermission

            @permission('new-version-students')
            <li class="sidebar-item"><a class="sidebar-link" href="{{route('students.new')}}">Show all (New version)</a></li>
            @endpermission

            @permission('deleted-students')
            <li class="sidebar-item"><a class="sidebar-link" href="{{route('deleted_students')}}">Deleted students</a></li>
            @endpermission

            @permission('add-students')
            <li class="sidebar-item"><a class="sidebar-link" href="{{route('students.create')}}">Add student</a></li>
            @endpermission

          </ul>
        </li>
        @endpermission



        @permission('teachers')
        <li class="sidebar-item {{ (\Str::contains(Request::path(), 'teachers')) ? 'active' : ''}}">
          <a href="#" data-bs-target="#teacher" data-bs-toggle="collapse" class="sidebar-link collapsed" aria-expanded="false">
            <i class="align-middle" data-feather="edit-3"></i> <span class="align-middle">Teachers</span>
          </a>
          <ul id="teacher" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
            @permission('show-teacher')
            <li class="sidebar-item"><a class="sidebar-link" href="{{route('teachers.index')}}">Show all teacher</a></li>
            @endpermission

            @permission('add-teacher')
            <li class="sidebar-item"><a class="sidebar-link" href="{{route('createteachers')}}">Add teacher</a></li>
            @endpermission
          </ul>
        </li>
        @endpermission
         
        
        @permission('make-reports')
        <li class="sidebar-item {{ (\Str::contains(Request::path(), 'report')) ? 'active' : ''}}">
          <a class="sidebar-link" href="{{route('report.index')}}">
            <i class="align-middle" data-feather="book"></i> <span class="align-middle">Reports</span>
          </a>
        </li>
        @endpermission

        @permission('display-alarms')
        <li class="sidebar-item {{ (\Str::contains(Request::path(), 'alarm')) ? 'active' : ''}}">
          <a class="sidebar-link" href="{{route('alarms.index')}}">
            <i class="align-middle" data-feather="clock"></i> <span class="align-middle">Alarm</span>
          </a>
        </li>
        @endpermission

        @permission('display-staff-members')
        <li class="sidebar-item {{ (\Str::contains(Request::path(), 'staff')) ? 'active' : ''}}">
          <a class="sidebar-link" href="{{route('staff.index')}}">
            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Staff members</span>
          </a>
        </li>
        @endpermission

        @permission('settings')
        <li class="sidebar-item {{ (Request::path() == 'settings') ? 'active' : ''}}">
          <a class="sidebar-link" href="{{route('settings')}}">
            <i class="align-middle" data-feather="settings"></i> <span class="align-middle">Settings</span>
          </a>
        </li>
        @endpermission


      </ul>

      <div class="sidebar-cta">
        <div class="sidebar-cta-content">
          <strong class="d-inline-block mb-2">💡 Hint</strong>
          <div class="mb-3 text-sm">
            This site created by Sayed Khaled so, if you face any problem 
          </div>
          <div class="d-grid">
            <a href="https://api.whatsapp.com/send?phone=201153198183" target="_blank" class="btn btn-primary">Contact me</a>
          </div>
        </div>
      </div>
    </div>
  </nav>