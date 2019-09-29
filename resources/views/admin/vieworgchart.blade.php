 @extends('orgcharttemplate')
 @section('orgchart')
  <script type='text/javascript'>//<![CDATA[ 
    $(window).load(function () {
      var options = new primitives.famdiagram.Config();
        var treeItems = {};
       var items = [
                     @foreach($files as $file)   
                                
                   
                      { id: '{{$file[0]['upgid']}}',title: "{{$file[0]['group']}}",email: "{{$file[0]['Name']}}", templateName: "contactTemplate",
                    itemTitleColor: "green",
                    phone:'{{$file[0]['upgGroup']}}',
                   parents: [{{$file[0]['Mother']}}], description: "{{$file[0]['Position']}}"},
                   
               @endforeach

            ];
      options.groupByType = primitives.common.GroupByType.Parent;
      options.verticalAlignmentType=primitives.common.VerticalAlignmentType.Bottom;
      options.orientationType = primitives.common.OrientationType.Top;
      options.pageFitMode = primitives.common.PageFitMode.None;
      options.graphicsType = primitives.common.GraphicsType.Auto;
      options.items = items;
      options.cursorItem = 2;
      options.linesWidth = 1;
      options.linesColor = "black";
      // options.hasSelectorCheckbox = primitives.common.Enabled.False;
      options.normalLevelShift = 35;
      options.dotLevelShift = 10;
      options.lineLevelShift = 10;
      options.normalItemsInterval = 40;
      options.dotItemsInterval = 10;
      options.lineItemsInterval = 10;
      options.arrowsDirection = primitives.common.GroupByType.false;
      options.showExtraArrows = false;
      options.autoSizeMaximum = true;
      options.navigationMode = primitives.common.NavigationMode.Default;
      options.highlightGravityRadius= 40;
      options.enablePanning= true;
      options.selectionPathMode = primitives.common.SelectionPathMode.FullStack;
      options.neighboursSelectionMode = primitives.common.NeighboursSelectionMode.ParentsChildrenSiblingsAndSpouses;
      options.templates = [getContactTemplate(), getContactTemplate2()];
      options.onItemRender = onTemplateRender;  
      // options.hasSelectorCheckbox = primitives.common.Enabled.True; 
      options.onSelectionChanging =   true; 
      options.selectCheckBoxLabel = "View Department";
      // options.enableMatrixLayout = true;
      // options.minimumMatrixSize = 3;



       function getContactTemplate2() {
        var result = new primitives.orgdiagram.TemplateConfig();
        result.name = "contactTemplate2";

        

        result.itemSize = new primitives.common.Size(220, 120);
        result.minimizedItemSize = new primitives.common.Size(3, 3);
        result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);


        var itemTemplate = jQuery(
          '<div class="bp-item bp-corner-all bt-item-frame">'
          + '<div name="titleBackground" class="bp-item bp-corner-all bp-title-frame" style="top: 2px; left: 2px; width: 216px; height: 20px;">'
            + '<div name="title" onclick="myfunction()" class="bp-item bp-title" id="test" style="top: 3px; left: 6px; width: 208px; height: 18px;">'
            + '</div>'
          + '</div>'
          // + '<div class="bp-item bp-photo-frame" style="top: 26px; left: 164px; width: 50px; height: 60px;">'
            // + '<img name="photo" style="height:60px; width:50px;" />'
          // + '</div>'
          + '<div name="phone" id="test2" style="visibility: hidden"; class="bp-item" style="top: 26px; left: 6px; width: 162px; height: 18px; font-size: 12px;"></div>'
          + '<div name="email" class="bp-item" style="top: 44px; left: 6px; width: 152px; height: 18px; font-size: 12px;"></div>'
          + '<div name="description" class="bp-item" style="top: 62px; left: 6px; width: 162px; height: 36px; font-size: 10px;"></div>'
        + '</div>'
        ).css({
          width: result.itemSize.width + "px",
          height: result.itemSize.height + "px"
        }).addClass("bp-item bp-corner-all bt-item-frame");
        result.itemTemplate = itemTemplate.wrap('<div>').parent().html();

        return result;
      }

      function getContactTemplate() {
        var result = new primitives.orgdiagram.TemplateConfig();
        result.name = "contactTemplate";


        result.itemSize = new primitives.common.Size(170, 140);
        result.minimizedItemSize = new primitives.common.Size(3, 3);
        result.highlightPadding = new primitives.common.Thickness(2, 2, 2, 2);


        var itemTemplate = jQuery(
          '<div class="bp-item bp-corner-all bt-item-frame">'
          + '<div name="titleBackground" class="bp-item bp-corner-all bp-title-frame" style="top: 2px; left: 2px; width: 216px; height: 20px;">'
            + '<div name="title" class="bp-item bp-title" id="test" style="top: 3px; left: 6px; width: 208px; height: 18px;">'
          // + '<div name="title" class="bp-item bp-title" id="test" style="top: 3px; left: 6px; width: 208px; height: 18px;">'
            + '</div>'
          + '</div>'
          // + '<div class="bp-item bp-photo-frame" style="top: 26px; left: 2px; width: 50px; height: 60px;">'
            // + '<img name="photo" style="height:60px; width:50px;" />'
          // + '</div>'
          + '<div name="phone" id="test2" style="visibility: hidden"; class="bp-item" style="top: 26px; left: 56px; width: 162px; height: 18px; font-size: 15px;"></div>'
          + '<center><div name="email" class="custom-position" style="top: 50px; left: 20px; width: 162px; height: 18px; font-size: 13px; text-decoration: underline;"></div></center>'
          + '<center><div name="description" class="custom-position" style="top: 65px; left: 20px; width: 162px; height: 36px; font-size: 10px;"></div></center>'
        + '</div>'
        ).css({
          width: result.itemSize.width + "px",
          height: result.itemSize.height + "px"
        }).addClass("bp-item bp-corner-all bt-item-frame");
        result.itemTemplate = itemTemplate.wrap('<div>').parent().html();

        return result;
      }
options.onSelectionChanged = function (e, data) {
        var selectedItems = $("#basicdiagram").famDiagram("option", "selectedItems");
        var message = "";
        for (var index = 0; index < selectedItems.length; index++) {
          var itemId = selectedItems[index];
          var itemConfig = treeItems[itemId];
          if (message != "") {
            message += ", ";
          }
          message += "<b>'" +  itemConfig.parents + "'</b>";

          window.location.href = 'http://localhost:8000/admin/8496/department/depID='+itemConfig.phone;

        }
        jQuery("#message").empty().append("User selected following items: " + message);


      };

      jQuery("#basicdiagram").famDiagram(options);

      jQuery(".treeItem").click(function (e) {
        var selectedItems = [];
        if (jQuery("#buttonA").prop("checked")) {
          selectedItems.push(0);
        }
        if (jQuery("#buttonB").prop("checked")) {
          selectedItems.push(1);
        }
        if (jQuery("#buttonC").prop("checked")) {
          selectedItems.push(2);
        }
        jQuery("#basicdiagram").famDiagram({
          selectedItems: selectedItems
        });
        jQuery("#basicdiagram").famDiagram("update", primitives.orgdiagram.UpdateMode.Refresh);
      })



for (var index = 0, len = items.length; index < len; index += 1) {
        treeItems[items[index].id] = items[index];
      }

      function onTemplateRender(event, data) {
        switch (data.renderingMode) {
          case primitives.common.RenderingMode.Create:
            /* Initialize widgets here */
            break;
          case primitives.common.RenderingMode.Update:
            /* Update widgets here */
            break;
        }

        var itemConfig = data.context;

        if (data.templateName == "contactTemplate2") {
          // data.element.find("[name=photo]").attr({ "src": itemConfig.image, "alt": itemConfig.title });
          data.element.find("[name=titleBackground]").css({ "background": itemConfig.itemTitleColor });

          var fields = ["title", "description", "phone", "email"];
          for (var index = 0; index < fields.length; index++) {
            var field = fields[index];

            var element = data.element.find("[name=" + field + "]");
            if (element.text() != itemConfig[field]) {
              element.text(itemConfig[field]);
            }
          }
        } else if (data.templateName == "contactTemplate") {
          // data.element.find("[name=photo]").attr({ "src": itemConfig.image, "alt": itemConfig.title });
          data.element.find("[name=titleBackground]").css({ "background": itemConfig.itemTitleColor });

          var fields = ["title", "description", "phone", "email"];
          for (var index = 0; index < fields.length; index++) {
            var field = fields[index];

            var element = data.element.find("[name=" + field + "]");
            if (element.text() != itemConfig[field]) {
              element.text(itemConfig[field]);
            }
          }
        }
      }

     

      console.log(options);
     $("#basicdiagram").famDiagram(options);

     
    });//]]>  


  </script>
@endsection


@section('menu')
 <li class="nav-item">
              <a class="nav-link" href="{{route('UserManage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">face</i>
               <p>Users</p>
              </a>
 </li>

 <li class="nav-item active">
              {{-- <a href="{{route('showDep',['upgid'=>$upgid,'id'=>$admingroup])}}" data-placement="right" title="Inbox"> --}}
                <a class="nav-link" href="#" data-placement="right" title="Inbox">
                <i class="material-icons">business</i>
               <p>Departments</p>
              </a>
 </li>

 <li class="nav-item">
              <a class="nav-link" href="{{route('viewRolePage',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">event_seat</i>
                <p>Positions</p>
              </a>
 </li>

 <li class="nav-item">
              <a class="nav-link" href="{{route('viewWorkflow',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">group</i>
               <p>Workflows</p>
              </a>
 </li>

 <li class="nav-item">
              <a class="nav-link" href="{{route('viewOwners',['upgid'=>$upgid])}}" data-placement="right" title="Inbox">
                <i class="material-icons">description</i>
                <p>Templates</p>
              </a>
 </li>
@endsection

@section('main_content')
<div style="width: 1400px; height: 1100px; border-style: dotted; border-color: white; background-color: #dcd0c0;">
  <center><h2 style="color: black">Organizational Chart for {{$personupgname}}</h2></center>
  <div id="basicdiagram" style="width: 1400px; height: 1000px;border-width: 1px;" />
</div>
</div>
<br>
        <a class="btn btn-info" style="float: right;" href="{{route('showDep',['upgid'=>$upgid,'id'=>$depid])}}">Back</a>
        <br>

@endsection

