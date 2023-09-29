@extends('shopers.master')

@section('title','Shopers')

@section('content')
<main class="mt-2">
    <!-- Add Product_form -->
  <form id="add_book" action="/shoper/product/add" method="POST" enctype="multipart/form-data">
    @csrf
    <p>Add New Product</p>

    <!-- Section 1 -->
    <div class="section_one">
        <div>
          <label>Category</label>
          <select name="category">
          @foreach($category as $i)
            <option value="{{$i->category}}">{{$i->category}}</option>
          @endforeach
          </select>
        </div>
        <div class="adv_category d-none">
          <label>Field</label>
          <select name="field" disabled onchange="find_branch(this.value);">
          @foreach($field as $i)
            <option value="{{$i->field}}">{{$i->field}}</option>
          @endforeach          
          </select>
        </div>
        <div class="adv_category d-none">
          <label>Branch</label>
          <select name="branch" disabled>
          @foreach($branch as $i)
            <option value="{{$i->branch}}">{{$i->branch}}</option>
          @endforeach          
          
          </select>
        </div>
        <div class="adv_category d-none">
          <label>STD / Semester</label>
          <select name="sem" disabled>
          @foreach($sem as $i)
            <option value="{{$i->sem}}">{{$i->sem}}</option>
          @endforeach          
          </select>
        </div>
        <div class="d-flex flex-row justify-content-end">
          <button class="btn btn-primary next_btn">Next</button>
        </div>            
    </div>
    <!-- End of Section 1 -->

    <!-- Section 2 -->
    <div class="section_two d-none">
        <div>
          <label>Product Name</label>
          <input type="text" placeholder="Product Name" name="name" required>
        </div>
        <div>
          <label>Product ISBN</label><input type="text" placeholder="ISBN NO" name="isbn" required></div>
        <div>
          <label>Author</label><input type="text" placeholder="Author Name" name="author" required></div>
        <div>
          <label>Number of Pages</label><input type="text" placeholder="Number of Pages" name="pages" required></div>
        <div>
          <label>Description</label><textarea placeholder='Write a Product Descrition' name="details" required></textarea></div>
        <div>
          <label>Quantity</label><input type="text" placeholder="Quantity" name="quantity" required></div>
        <div>
          <label>Language</label><input type="text" placeholder="Language" name="lang" required></div>
        <div>
          <label>Images</label>
          <div class="custom-file m-0 ml-3">
            <input class="custom-file-input" type="file" id="p_img" name="img" accept="image/*" required>
            <label class="custom-file-label w-100" for="p_img">Choose Product Image</label>
          </div>
        </div>
        <div>
          <label>Price</label><input type="text" placeholder="Price of One Product" name="price" required></div>
        <div class="d-flex flex-row justify-content-between">
          <button class="btn btn-outline-primary prev_btn">Previous</button>
          <button class="btn btn-primary" name="add">ADD</button>
        </div>
      </div><!-- Section 2 -->
  </form><!-- Form of Add Book Container -->
</main>
<script type="text/javascript">

    const add_book = $('#add_book')[0];

    add_book.category.addEventListener('change',function(){
        if(this.value=='Education'){
            $('.adv_category').removeClass('d-none')
            add_book.field.removeAttribute('disabled');
            add_book.branch.removeAttribute('disabled');
            add_book.sem.removeAttribute('disabled');
        } 
        else{
            $('.adv_category').addClass('d-none')
            add_book.field.setAttribute('disabled','dis');
            add_book.branch.setAttribute('disabled','dis');
            add_book.sem.setAttribute('disabled','dis');
        }
    });

    $('.next_btn').click(function(e){
      e.preventDefault();
      $('.section_one').addClass('d-none');
      $('.section_two').removeClass('d-none');
    });
    
    $('.prev_btn').click(function(e){
      e.preventDefault();
      $('.section_one').removeClass('d-none');
      $('.section_two').addClass('d-none');
    });

    function find_branch(field_name){
      $.ajax({
        url:"/find_branch/"+field_name,
        method: "GET",
        success:function(data){
          const branch = JSON.parse(data);
          var input;
          for(let i=0;i<branch.length;i++){
            input += "<option value="+branch[i].branch+">"+branch[i].branch+"</option>";
          }
          $('[name="branch"]').html(input);
        }      
      });
    }

</script>  
@endsection