$(function() {
    "use strict";

    $(".preloader").fadeOut();
    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").on('click', function() {
        $("#main-wrapper").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("ti-menu");
    });
    $(".search-box a, .search-box .app-search .srh-btn").on('click', function() {
        $(".app-search").toggle(200);
        $(".app-search input").focus();
    });

    // ============================================================== 
    // Resize all elements
    // ============================================================== 
    $("body, .page-wrapper").trigger("resize");
    $(".page-wrapper").delay(20).show();
    
    //****************************
    /* This is for the mini-sidebar if width is less then 1170*/
    //**************************** 
    var setsidebartype = function() {
        var width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width;
        if (width < 1170) {
            $("#main-wrapper").attr("data-sidebartype", "mini-sidebar");
        } else {
            $("#main-wrapper").attr("data-sidebartype", "full");
        }
    };
    $(window).ready(setsidebartype);
    $(window).on("resize", setsidebartype);

});

$(document).ready(function(){
 var next = 1;
 var now = 1;
 $('.btn-add-more'+next).on('click', function(event) {
    $('.btn-add-more'+next).val = 'asd';
        if(next == 1) {
            $('#btn-delete-field1').css('display', 'block')
        }
     next++;
     console.log(next);
     var html = '';
     html += '<tr id="field'+next+'">';
     var phpCode = "<?php echo 'anjing'; ?>";
     html += '<td><select name="product_code[]" id="product_code[]" class="form-control"><option value="">Pilih bahan</option>@foreach ($product as $product_item)<option value="{{ $product_item->product_code }}">{{ $product_item->product_code }} - {{ $product_item->name }}</option>@endforeach</select></td> <td><input type="number" name="dose[]" id="dose[]" class="form-control" placeholder="Masukkan takaran disini"></td><td><button type="button" class="btn btn-danger ml-4 btn-delete-field" id="btn-delete-field'+next+'"><span class="fa fa-minus"></span></button></td>'
     html += '</tr>';
     $('tbody').append(html);
     now = next;
     event.stopPropagation();
     $('.btn-delete-field').on('click', function(event) {
        console.log('id : '+this.id.charAt(this.id.length - 1));
        event.preventDefault();
        
        var fieldNum =this.id.charAt(this.id.length-1);
        var fieldID = "#field" + fieldNum;
        
        $(this).remove();
        $(fieldID).remove();
     })
    })    
});

// $(document).ready(function(){
//     var next = 1;
//     $(".add-more").click(function(e){
//         console.log('add new field')
//         e.preventDefault();
//         var addto = "#field" + next;
//         var addRemove = "#field" + (next);
//         next = next + 1;
//         // var newIn = '<input autocomplete="off" class="input form-control" id="field' + next + '" name="field' + next + '" type="text">';
//         var newIn = '<div class="row mb-2 field"><div class="col"><select name="product_code[]" id="product_code[]" class="form-control"><option value="">Pilih bahan</option>@php foreach ($product as $product_item)<option value="{{ $product_item->product_code }}"><?php echo $product_item->product_code ?> - {{ $product_item->name }}</option>@endphp</select></div><div class="col"><input autocomplete="off" class="input form-control" id="field1" name="prof1" type="text" placeholder="Type something" data-items="8"/></div><div class="col">';
//         var newInput = $(newIn);
//         var removeBtn = '<button id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >-</button></div><div id="field">';
//         var removeButton = $(removeBtn);
//         $(addto).after(newInput);
//         $(addRemove).after(removeButton);
//         $("#field" + next).attr('data-source',$(addto).attr('data-source'));
//         $("#count").val(next);  
        
//             $('.remove-me').click(function(e){
//                 e.preventDefault();
//                 var fieldNum = this.id.charAt(this.id.length-1);
//                 var fieldID = "#field" + fieldNum;
//                 $(this).remove();
//                 $(fieldID).remove();
//             });
//     });
    

    
// });

