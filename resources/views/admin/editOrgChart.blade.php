<!DOCTYPE html>
<html>
<head>
 <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/orgchart/css/app.css') }}">

    <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/orgchart/css/jquery.orgchart.css') }}">
    <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/orgchart/css/jquery.orgchart.min.css') }}">
    <link rel='stylesheet' type='text/css' href="{{ URL::asset('css/orgchart/css/style.css') }}">
</head>
<body>
<div class="container">
  <div class="row justify-content-start mt-2 ml-2">
    @foreach($readchart as $data)
      <a class="btn btn-warning" href="{{route('showDep',['upgid'=>$upgid,'id'=>$data->group_id])}}">Back</a>
      @endforeach
    </div>

    <div class="container mt-3">

      <style type="text/css">
    #chart-container { background-color: #eee; height: 300px; }
    .orgchart { background: #fff; }
    .orgchart.view-state .edge { display: none; }
    .orgchart .node { width: 150px; }
    .orgchart .node .title .symbol { margin-top: 1px; }
    #edit-panel {
      position: relative;
      left: 10px;
      width: calc(100% - 40px);
      border-radius: 4px;
      float: left;
      margin-top: 10px;
      padding: 10px;
      color: #00000;
      background-color: #c77d21;
    }
    #edit-panel .btn-inputs { font-size: 24px; }
    #edit-panel.view-state>:not(#chart-state-panel) { display: none; }
    #edit-panel label { font-weight: bold; }
    #edit-panel.edit-parent-node .selected-node-group { display: none; }
    #chart-state-panel, #selected-node, #btn-remove-input { margin-right: 20px; }
    #edit-panel button {
      color: #333;
      background-color: #fff;
      display: inline-block;
      padding: 6px 12px;
      margin-bottom: 0;
      line-height: 1.42857143;
      text-align: center;
      white-space: nowrap;
      vertical-align: middle;
      -ms-touch-action: manipulation;
      touch-action: manipulation;
      cursor: pointer;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      background-image: none;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    #edit-panel.edit-parent-node button:not(#btn-add-nodes) { display: none; }
    #edit-panel button:hover,.edit-panel button:focus,.edit-panel button:active {
      border-color: #eea236;
      box-shadow:  0 0 10px #eea236;
    }
    #new-nodelist {
      display: inline-block;
      list-style:none;
      margin-top: -2px;
      padding: 0;
      vertical-align: text-top;
    }
    #new-nodelist>* { padding-bottom: 4px; }
    .btn-inputs { vertical-align: sub; }
    #edit-panel.edit-parent-node .btn-inputs { display: none; }
    .btn-inputs:hover { text-shadow: 0 0 4px #fff; }
    .radio-panel input[type='radio'] { display: inline-block;height: 24px;width: 24px;vertical-align: top; }
    #edit-panel.view-state .radio-panel input[type='radio']+label { vertical-align: -webkit-baseline-middle; }
    #btn-add-nodes { margin-left: 20px; }
  </style>


      @foreach($readchart as $rc)
  <select name="org-group" id="group-org" class="form-group">
      @foreach($groups as $group)
      @if($group->group_id==$rc->group_id)
      <option value="{{$group->group_id}}" selected>{{$group->groupName}}</option>
      @else
      <option value="{{$group->group_id}}">{{$group->groupName}}</option>
      @endif
      @endforeach
    </select>
    @endforeach
  <div id="chart-container"></div>
  <div id="edit-panel" class="view-state">
    <span id="chart-state-panel" class="radio-panel">
      <input type="radio" name="chart-state" id="rd-view" value="view" checked="true"><label for="rd-view">View</label>
      <input type="radio" name="chart-state" id="rd-edit" value="edit"><label for="rd-edit">Edit</label>
    </span>
    <label class="selected-node-group">selected node:</label>
    <input type="text" id="selected-node" class="selected-node-group">

<label>selected node upg:</label>
<input type="text" placeholder="selectedNodeUpg" id="selectednodeupg">

    <!-- Button trigger modal -->
<button type="button" class="btn btn-primary" onclick="openExampleModal()">
  New node
</button>

<!-- Modal -->
<div class="modal" id="exampleModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Choose</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="lists-table">
          <thead>
        <th>Names</th>
        <th>Group</th>
        <th>Position</th>
        </thead>
        <tbody>
        @foreach($lists as $list)
        <tr id={{$list->upg_id}}>
        <td id="name-{{$list->upg_id}}"><a id="link-{{$list->upg_id}}" href="javascript:submitUserList({{$list->upg_id}},{{$list->group_id}}, {{$list->pos_id}})">{{$list->lastname}} {{$list->firstname}}</a></td>
          <td>{{$list->posName}}</td>
          <td>{{$list->groupName}}</td>
      </tr>
      
        @endforeach
      </tbody>
       </table>
      </div>
    </div>
  </div>
</div>



  <label>Name</label>
  <ul id="new-nodelist">
    <input type="text" placeholder="Name" id="nodetext" class="new-node">
    <input type="text" class="upg-ID" placeholder="upgID" id="upg">
  </ul>
  {{-- <label>Department</label> --}}
  <input type="text" placeholder="Department" id="department">
  {{-- <label>Position</label> --}}
  <input type="text" placeholder="Position" id="position">
  {{-- <label>upg</label> --}}

  

  {{-- <input type="text" placeholder="upgID" id="upg"> --}}
 {{--  <label>posid</label> --}}
  <input type="text" placeholder="posID" id="posID" >
  {{-- <label>groupid</label> --}}
  <input type="text" placeholder="groupID" id="groupID">
  {{-- orgchartID --}}
  <input type="text" placeholder="orgchartid" id="orgchartID" value="{{$orgchart_id}}">
    {{-- <label>new node:</label>
    <ul id="new-nodelist">
      <li><input type="text" id="nodetext" class="new-node"></li>
    </ul> --}}
  
    <i class="material-icons" id="btn-add-input">add_circle</i>
    <i class="material-icons" id="btn-remove-input">remove_circle</i>
    <span id="node-type-panel" class="radio-panel">
      <input type="radio" name="node-type" id="rd-parent" value="parent"><label for="rd-parent">Parent(root)</label>
      <input type="radio" name="node-type" id="rd-child" value="children"><label for="rd-child">Child</label>
      <input type="radio" name="node-type" id="rd-sibling" value="siblings"><label for="rd-sibling">Sibling</label>
    </span>
    <button type="button" id="btn-add-nodes">Add</button>
    <button type="button" id="btn-delete-nodes">Delete</button>
    <button type="button" id="btn-reset">Reset</button>
    <button type="button" id="btn-save">Save</button>
  </div>
  <script type="text/javascript">
    function openExampleModal()
    {
      var modal = document.getElementById('exampleModal');
      modal.style.display = "block";
    }
    function submitUserList($upg_id ,$group_id, $pos_id){
      var name = document.getElementById('link-'+$upg_id);
      var namefield = document.getElementById('nodetext');
      namefield.value = name.innerHTML;

      var modal = document.getElementById('exampleModal');
              modal.style.display = "none";
          
      var upgfield =document.getElementById('upg');
      upgfield.value = $upg_id;

       var posfield =document.getElementById('posID');
      posfield.value = $pos_id;

       var groupfield =document.getElementById('groupID');
      groupfield.value = $group_id;
       // console.log($upg_id);
       var modal = document.getElementById('exampleModal');
       modal.style.display = "none";
    }
  </script>
  
  <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/html2canvas.min.js') }}"></script>
  <script type="text/javascript" src="{{ URL::asset('/js/orgchartjs/jquery.orgchart.js') }}"></script>
  <script type="text/javascript">
     $(function() {

    var datascource = <?php
    echo $files;
    ?>;

      var orgchartnodes = Array();
      var removenodearray = Array();
    var getId = function() {
      return (Math.floor(Math.random() * 10001)+1);
    };

    var oc = $('#chart-container').orgchart({
      'data' : datascource,
      'exportButton': true,
      'exportFilename': 'OrgChart',
      'parentNodeSymbol': 'fa-th-large',
       // 'nodeContent': 'job',
      'createNode': function($node, data) {
        $node[0].id = getId();
       
      }
    });
  


    oc.$chartContainer.on('click', '.node', function() {
      var $this = $(this);
      $('#selected-node').val($this.find('.title').text()).data('node', $this);
      $('#selectednodeupg').val($this.find('.upgid').text()).data('node',$this);
    });

    oc.$chartContainer.on('click', '.orgchart', function(event) {
      if (!$(event.target).closest('.node').length) {
        $('#selected-node').val('');
      }
    });

    $('input[name="chart-state"]').on('click', function() {
      $('.orgchart').toggleClass('view-state', this.value !== 'view');
      $('#edit-panel').toggleClass('view-state', this.value === 'view');
      if ($(this).val() === 'edit') {
        $('.orgchart').find('tr').removeClass('hidden')
          .find('td').removeClass('hidden')
          .find('.node').removeClass('slide-up slide-down slide-right slide-left');
      } else {
        $('#btn-reset').trigger('click');
      }
    });

    $('input[name="node-type"]').on('click', function() {
      var $this = $(this);
      if ($this.val() === 'parent') {
        $('#edit-panel').addClass('edit-parent-node');
        $('#new-nodelist').children(':gt(0)').remove();
      } else {
        $('#edit-panel').removeClass('edit-parent-node');
      }
    });

    $('#btn-add-input').on('click', function() {
      $('#new-nodelist').append('<li><input type="text" id="nodetext"  class="new-node"></li>');
    });

    $('#btn-remove-input').on('click', function() {
      var inputs = $('#new-nodelist').children('li');
      if (inputs.length > 1) {
        inputs.last().remove();
      }
    });
    
    $('#btn-add-nodes').on('click', function() {
      var $chartContainer = $('#chart-container');
      var nodeVals = [];
      var x = document.getElementById("nodetext").value; //new node text box



      //backend
      //get all value of the input
      var pos_id= $('#posID').val();
      var upg_id = $('#upg').val();
      var group_id = $('#groupID').val();
      var orgchart_id = $('#orgchartID').val();

      var nodeObject = {'nodeid': getId(), 'pos_id': pos_id, 'upg_id':upg_id,'group_id':group_id, 'orgchart_id': orgchart_id};

      orgchartnodes.push(nodeObject);      
        console.log(orgchartnodes);
  

       $('#posID').val('');
       $('#groupID').val('');
     

      $('#new-nodelist').find('.new-node').each(function(index, item) {
        var validVal = item.value.trim();
        if (validVal.length) {
          nodeVals.push(validVal);
          //console.log(nodeVals);
        }
      });

      var $node = $('#selected-node').data('node');
      if (!nodeVals.length) {
        alert('Please input value for new node');
        return;
      }
      var nodeType = $('input[name="node-type"]:checked');
      if (!nodeType.length) {
        alert('Please select a node type');
        return;
      }
      if (nodeType.val() !== 'parent' && !$('.orgchart').length) {
        alert('Please creat the root node firstly when you want to build up the orgchart from the scratch');
        return;
      }
      if (nodeType.val() !== 'parent' && !$node) {
        alert('Please select one node in orgchart');
        return;
      }
      if (nodeType.val() === 'parent') {
        if (!$chartContainer.children('.orgchart').length) {// if the original chart has been deleted
          oc = $chartContainer.orgchart({
            'data' : { 'name': nodeVals[0]},
            'exportButton': true,
            'exportFilename': 'OrgChart',
            'parentNodeSymbol': 'fa-th-large',
            // 'nodeContent': 'job',
            'createNode': function($node, data) {
              $node[0].id = getId();
              
            }
          });
          oc.$chart.addClass('view-state');
        } else {
          oc.addParent($chartContainer.find('.node:first'), { 'name': nodeVals[0], 'name2': nodeVals[1] ,'Id': getId() });
        }
      } else if (nodeType.val() === 'siblings') {
        oc.addSiblings($node,
          { 'siblings': nodeVals.map(function(item) { return { 'name': item, 'relationship': '110', 'Id': getId() }; })
        });
      } else {
        var hasChild = $node.parent().attr('colspan') > 0 ? true : false;
        if (!hasChild) {
          var upgid = $('#upg').val(); //MAO NI BAI
          var rel = nodeVals.length > 1 ? '110' : '100';
          oc.addChildren($node, {
              'children': nodeVals.map(function(item) {
                return { 'name': item, 'relationship': rel, 'Id': getId(), 'upgid': upgid};
              })
            }, $.extend({}, $chartContainer.find('.orgchart').data('options'), { depth: 0 }));
        } else {
          oc.addSiblings($node.closest('tr').siblings('.nodes').find('.node:first'),
            { 'siblings': nodeVals.map(function(item) { return { 'name': item, 'relationship': '110', 'Id': getId() }; })
          });
        }
      }
    });

    $('#btn-delete-nodes').on('click', function() {
        var $node = $('#selected-node').data('node');
        var removeUpgid= $('#selectednodeupg').val();
        var found = "-1";
        var foundinArray = $.map(orgchartnodes, function(val){
          if(val.upg_id==removeUpgid)
             found = "1";
        });
      if (found != "-1") {
      orgchartnodes = $.grep(orgchartnodes,function(e){
        return e.upg_id != removeUpgid;
      });
      console.log(orgchartnodes);
    }
    else{
      removenodearray.push(removeUpgid);
      console.log(removenodearray);

    }
      //console.log(found);

      if (!$node) {
        alert('Please select one node in orgchart');
        return;
      } else if ($node[0] === $('.orgchart').find('.node:first')[0]) {
        if (!window.confirm('Are you sure you want to delete the whole chart?')) {
          return;
        }
      }
      oc.removeNodes($node);
      $('#selected-node').val('').data('node', null);
    });

    $('#btn-reset').on('click', function() {
      $('.orgchart').find('.focused').removeClass('focused');
      $('#selected-node').val('');
      $('#new-nodelist').find('input:first').val('').parent().siblings().remove();
      $('#node-type-panel').find('input').prop('checked', false);
    });

 $('#btn-save').on('click', function() {
  var filename= Math.floor(Math.random() * 10000);

   var hierarchy = oc.getHierarchy();
   // $('#btn-save').after('<pre>').next().append(JSON.stringify(hierarchy, null, 2));
   var res= JSON.stringify(hierarchy,null,2);
   $('#result').html(res);
  var group = $('#group-org').val();
  var orgchart_id =$('#orgchartID').val();
  // saveAs(blob, filename+".txt");
  // var request = $.get('/uploadorgchart');
  $.ajax({
    url:'/admin/{{$upgid}}/updateOrgChart',
    type:'GET',
    data:{id:res,
          orgchartid:orgchart_id,
          group_id: group,
          orgchartnodesArray: orgchartnodes,
          removenodesarray: removenodearray

        },
   success: function(data)
   {
    console.log(data);
   }
  });
});



    });


  </script>
    </div>
</div>
<script src="{{URL::asset('js/orgchartjs/jquery.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="{{URL::asset('css/datatables/jQuery.dataTables.js')}}"></script>
<script type="text/javascript">
        $(document).ready(function () {
            $('#lists-table').DataTable();
        });
    </script> 
<script src="{{URL::asset('js/orgchartjs/jquery.orgchart.js')}}" type="text/javascript"></script>
<script src="{{URL::asset('js/orgchartjs/html2canvas.min.js')}}" type="text/javascript"></script>
</body>
</html>