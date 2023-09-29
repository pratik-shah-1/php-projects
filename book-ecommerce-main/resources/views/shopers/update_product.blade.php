@extends('shopers.master')
@section('title','Shopers')

<!-- -------------------------------------------------------------------------------------- --
  Category Change thavi joie....
!-- -------------------------------------------------------------------------------------- -->
@section('content')
@if(session()->has('update'))
  <script>swal('Updaet Product Successfully','','success');</script>
@endif

<main class="mt-2">
    <!-- Add Product_form -->
    <!-- {{$book->id}} -->
  <form id="add_book" action="/shoper/product/update/{{$book->p_id}}" method="POST" enctype="multipart/form-data">
    @csrf
    <p>Update Product</p>
    <!-- Section One for Book Category -->
    <div class="section_one">
        <div>
          <label>Category</label><select name="category">
            @foreach($category as $c)
              <option value="{{$c->category}}">{{$c->category}}</option>
            @endforeach
          </select>
        </div>
        <div class="adv_category d-none">
          <label>Field</label>
          <select name="field" disabled>
            @foreach($field as $f)
              <option value="{{$f->field}}">{{$f->field}}</option>
            @endforeach
          </select>
        </div>
        <div class="adv_category d-none">
          <label>Branch</label>
          <select name="branch" disabled>
            @foreach($branch as $b)
              <option value="{{$b->branch}}">{{$b->branch}}</option>
            @endforeach
          </select>
        </div>
        <div class="adv_category d-none">
          <label>STD / Semester</label>
          <select name="sem" disabled>
            @foreach($sem as $s)
              <option value="{{$s->sem}}">{{$s->sem}}</option>
            @endforeach
          </select>
        </div>
        <div class="d-flex flex-row justify-content-end">
          <button class="btn btn-primary next_btn">Next</button>
        </div>            
    </div><!-- End of Section 1 -->

    <!-- Section two from book info -->
    <div class="section_two d-none">
        <div>
          <label>Product Name</label>
          <input type="text" placeholder="Product Name" name="name" value="{{$book->name}}" required></div>
        <div>
          <label>Product ISBN</label>
          <input type="text" placeholder="ISBN NO" name="isbn" value="{{$book->isbn}}" required></div>
        <div>
          <label>Author</label>
          <input type="text" placeholder="Author Name" name="author" value="{{$book->author}}" required></div>
        <div>
          <label>Number of Pages</label>
          <input type="text" placeholder="Number of Pages" name="pages" value="{{$book->pages}}" required></div>
        <div>
          <label>Description</label>
          <textarea placeholder='Write a Product Descrition' name="details" required>{{$book->details}}</textarea></div>
        <div>
          <label>Quantity</label>
          <input type="text" placeholder="Quantity" name="quantity" value="{{$book->quantity}}" required></div>
        <div>
          <label>Language</label>
          <input type="text" placeholder="Language" name="lang" value="{{$book->lang}}" required></div>
        <div>
          <label>Images</label>
          <div class="custom-file m-0 ml-3">
            <input class="custom-file-input" type="file" id="p_img" name="img" accept="image/*">
            <label class="custom-file-label w-100" for="p_img">Choose Product Image</label>
          </div>
        </div>
        <div>
          <label>Price</label>
          <input type="text" placeholder="Price of One Product" name="price" value="{{$book->price}}" required></div>
        <div class="d-flex flex-row justify-content-between">
          <button class="btn btn-outline-primary prev_btn">Previous</button>
          <button class="btn btn-primary" name="add">UPDATE</button>
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

</script>  
@endsection