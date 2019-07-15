@extends('layouts.app')
@section('content')


<div class="container" style="width:900px;">

  <br /><br />
  <div class="row">
    <div class="col-md-6">
      <h3 align="center"><u>Add New Department</u></h3>
      <br />
      <form method="post" action="/departments/add_dep" id="treeview_form">
        {{ csrf_field() }}
        {{ method_field('post') }}
        <div class="form-group">
          <label>Select Parent Department</label>
          <select name="parent_department" class="form-control">
            @foreach($departments as $key=>$department)
            <option id="{{$department->id}}" value="{{$department->id}}">{{$department->name}}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label>Enter Department Name</label>
          <input type="text" name="child_department" id="child_department" class="form-control">
        </div>
        <div class="form-group">
          <input type="submit" name="action" id="action" value="Add" class="btn btn-info" />
        </div>
      </form>
    </div>
    <div class="col-md-6">
      <h3 align="center"><u>Department Tree</u></h3>
      <br />
      <div id="parent_department">


      </div>
    </div>
  </div>
</div>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/themes/default/style.min.css" />
<script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.8/jstree.min.js"></script>

<script>
  $(document).ready(function() {

    add_tree();

    fill_treeview();

    function fill_treeview() {
      $('#jstree_div').jstree({
        'core': {
          'data': {
            'url': "<?php URL::to('/departments/fill_treeview');?>",
            'dataType': "json"
          },
          "themes": {
            "icons": true,
            "dots": true,
            "responsive": true,
            "stripes": true
          }
        }
      });

    }

    function add_tree() {
      $.ajax({
        url: '/add_tree',
        success: function(data) {
          alert('data');
          $('parent_department').html(data);
        }
      });
    }

    $('#treeview_form').on('submit', function(event) {
      event.preventDefault();
      $.ajax({
        url: "/add_tree",
        method: "POST",
        data: $(this).serialize(),
        success: function(data) {
          fill_treeview();
          fill_parent_department();
          $('#treeview_form')[0].reset();
          alert(data);
        }
      })
    });
  });
</script>

@endsection