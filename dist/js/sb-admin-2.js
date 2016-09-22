$(function() {

    $('#side-menu').metisMenu();

});
//Loads the correct sidebar on window load,
//collapses the sidebar on window resize.
// Sets the min-height of #page-wrapper to window size
$(function() {
    $(window).bind("load resize", function() {
        var topOffset = 50;
        var width = (this.window.innerWidth > 0) ? this.window.innerWidth : this.screen.width;
        if (width < 768) {
            $('div.navbar-collapse').addClass('collapse');
            topOffset = 100; // 2-row-menu
        } else {
            $('div.navbar-collapse').removeClass('collapse');
        }

        var height = ((this.window.innerHeight > 0) ? this.window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $("#page-wrapper").css("min-height", (height) + "px");
        }
    });

    var url = window.location;
    // var element = $('ul.nav a').filter(function() {
    //     return this.href == url;
    // }).addClass('active').parent().parent().addClass('in').parent();
    var element = $('ul.nav a').filter(function() {
     return this.href == url;
    }).addClass('active').parent();

    while(true){
        if (element.is('li')){
            element = element.parent().addClass('in').parent();
        } else {
            break;
        }
    }
});
$( document ).ready(function() {
    $( ".operatiuneFinanciara" ).change(function() {
        var fieldClass=$(this).val();
        var fieldvalue=$(this).find(":selected").html() ;
        console.log('da');
        console.log(fieldvalue);
        $(".operatiune").addClass("hide");
        $("."+fieldClass).removeClass("hide");
        $("."+fieldClass+ " .panel-heading").html(fieldvalue);
        });
});
$("#financiarForm").submit(function(e){
    e.preventDefault;
     //var formData=$(".operatiune .seara").serialize();
    var option=$(".operatiuneFinanciara").val();
    var formData=form_to_json(".operatiune ."+option);

    $.ajax({
        url: ApiUrl+'finance/monetar/data='+JSON.stringify(formData)+'/option='+option,
        type: 'GET',
       // dataType: 'json',
        success: function(data) {

            var dataArray = [];
            var obj = $.parseJSON(data);

            $.each(obj, function (index, value) {
                dataArray.push([ value ]);
            });

            if(dataArray[0]=='Yes'){
                console.log('dialog OK');
                $("#alert-dimissable-text").html("Operatie reusita");
                $(".alert-dismissable").removeClass("hide");

            }
        }
    });



    return false;

});
$(".clienti #adaug").click(function(){
    var formData=form_to_json(".clienti ");

    $.ajax({
        url: ApiUrl+'finance/client/data='+JSON.stringify(formData)+'/option=add',
        type: 'GET',
        // dataType: 'json',
        success: function(data) {

            var dataArray = [];
            var obj = $.parseJSON(data);

            $.each(obj, function (index, value) {
                dataArray.push([ value ]);
            });

            if(dataArray[0]=='Yes'){

                loadClients(MainPlayground);
                console.log('dialog OK');
                $("#alert-dimissable-text").html("Operatie reusita");
                $(".alert-dismissable").removeClass("hide");

            }
        }
    });



});

function calculateClient(id){
    $.ajax({
        url: ApiUrl+'finance/client/1/'+ id +'/calculate',
        type: 'POST',
        // dataType: 'json',
        success: function(data) {

            var dataArray = [];
            var obj = $.parseJSON(data);

            $.each(obj, function (index, value) {
                dataArray.push([ value ]);
            });

            if(obj.operation=='ok'){
                console.log('dialog OK');
                $("#alert-dimissable-text").html("Operatie reusita");
                $(".alert-dismissable").removeClass("hide");

            }
        }
    });

    loadClients(MainPlayground);

}
$( document ).ready(function() {

    if ( $('.client-data').length > 0 ) {
        loadClients(MainPlayground);
    }
});

$(".productAdd .barcodeID").blur(function(){
    toggleSubmit("hide");
    var barcode=$(this).val();
    $(this).val("");

    var addedBy=1
    var Added=0;
    $.ajax({
        url: ApiUrl+'finance/inventory/checkProduct/'+MainPlayground+'/'+barcode,
        type: 'GET',
        async: false,
        success: function(data) {
            var obj = $.parseJSON(data);
            var op=obj.operation;

            if(op==='ok'){

                $("#extraData").html(" Produs: "+$.parseJSON(obj.data).name);
                $("#extraData").append(" <br>Cantitate "+qtyProduct(MainPlayground,barcode));

            }
            else {

                $("#extraData").html('<input type="text" name="name" class=" form-control input-lg input-group-lg " placeholder="Nume"><input type="text" name="price" class=" form-control input-lg input-group-lg " placeholder="Pret">');
            }
            toggleSubmit("show");
            $("tbody.productAdd>tr:nth-child(1)>td:nth-child(3)>#adaug").click(function(){
                if(op==='ok'){
                    if(Added==0){
                        addProduct(barcode,MainPlayground,addedBy,$(".qty").val(),0);
                    }
                    Added=1;

                }
                else {
                    var name=$("#extraData input[name='name']").val();
                    var price=$("#extraData input[name='price']").val();
                    if(name.length>0 & price.length>0){
                        createProduct(barcode,MainPlayground,addedBy,name,price);
                    }


                }
                $("#extraData").html("");
                toggleSubmit("hide");

            })
            loadProducts(MainPlayground);

        }
    });

//console.log(jsonArray);
})
    $(".productRemove .barcodeID").blur(function(){
        toggleSubmit("hide");
        var barcode=$(this).val();
        $(this).val("");

        var addedBy=1
        $.ajax({
            url: ApiUrl+'finance/inventory/checkProduct/'+MainPlayground+'/'+barcode,
            type: 'GET',
            async: false,
            success: function(data) {
                var obj = $.parseJSON(data);
                var op=obj.operation;

                if(op==='ok'){
                    qty= qtyProduct(MainPlayground,barcode);

                    $("#extraData").html("<span class='product-name'>Produs: "+$.parseJSON(obj.data).name)+"</span>";
                    $("#extraData").append("<span class='product-qty'>Cantitate:"+qty+" </span>");

                    if(qty>0){
                        toggleSubmit("show");
                    }
                    else
                    {   toggleSubmit("hide");}


                }
                else {

                    $("#extraData").html('<input type="text" name="name" class=" form-control input-lg input-group-lg " placeholder="Nume"><input type="text" name="price" class=" form-control input-lg input-group-lg " placeholder="Pret">');
                    toggleSubmit("show");
                }

                $(document).on('click', 'tbody.productRemove>tr:nth-child(1)>td:nth-child(2)>#adaug', function() {
                    if(op==='ok'){
                        addProduct(barcode,MainPlayground,addedBy,-1,0);
                    }

                    $("#extraData").html("");
                    toggleSubmit("hide");
                });
                loadProducts(MainPlayground);
            }
        });

//console.log(jsonArray);
    })



function qtyProduct(playground,barcode){
var op=""

var qty=""
    $.ajax({
        url: ApiUrl+'finance/inventory/totalProduct/'+playground+'/'+barcode,
        type: 'GET',
        async: false,
        success: function(data) {
            var obj = $.parseJSON(data);
            op=obj.operation;
            if(op==="ok"){

                qty=$.parseJSON(obj.data).qty;


            }
        }
    });
return qty;
}
function doReturn(value,where){
    console.log(value);
    return value;
}
function addProduct(barcode,playground,addedBy,qty,clientID){

    $.ajax({
        url: ApiUrl+'finance/inventory/checkProduct/'+MainPlayground+'/'+barcode,
        type: 'GET',
        async: false,
        success: function(data) {
            var obj = $.parseJSON(data);
            var op=obj.operation;

            if(op==='ok'){

                $("#extraData").html(" Produs: "+$.parseJSON(obj.data).name);
                $("#extraData").append(" <br>Cantitate "+qtyProduct(MainPlayground,barcode));
                var txt;
                var r = confirm("Cumpara "+ $.parseJSON(obj.data).name+' din care mai sunt '+qtyProduct(MainPlayground,barcode)+' bucati');
                if (r == true) {
                    $.ajax({
                        url: ApiUrl+'finance/inventory/addProduct/'+playground+'/'+barcode+'/'+addedBy+'/'+qty+'/'+clientID,
                        type: 'GET',
                        success: function(data) {
                            var obj = $.parseJSON(data);
                            var op=obj.operation;
                            if(op==='ok'){
                                if(qty>0)
                                    $("#extraData").html("Adaugat "+ qty+" bucati");
                                else
                                    $("#extraData").html("Sters 1 bucata");
                            }
                            else {
                                $("#extraData").html("Numele si pretul trebuie completat");
                            }
                        }
                    });                }
            }
            else {

                $("#extraData").html('<input type="text" name="name" class=" form-control input-lg input-group-lg " placeholder="Nume"><input type="text" name="price" class=" form-control input-lg input-group-lg " placeholder="Pret">');
            }
        }
    });



}
function createProduct(barcode,playground,addedBy,name,price){
    $.ajax({
        url: ApiUrl+'finance/inventory/createProduct/'+playground+'/'+barcode+'/'+addedBy+'/'+name+'/'+price,
        type: 'GET',
        success: function(data) {
            var obj = $.parseJSON(data);
            var op=obj.operation;
            if(op==='ok'){
                $("#extraData").html("Adaugat");

            }
            else {
                $("#extraData").html("Numele si pretul trebuie completat");
            }
        }
    });

}

function loadClients(playgroundID)
{

    $.ajax({
        url: ApiUrl+'finance/client/getall/plagroundID='+playgroundID,
        type: 'GET',
        // dataType: 'json',
        success: function(data) {


            var obj = $.parseJSON(data);
            var id,name,entry,details,consum,price,exit,temmpJson;
            $(".clientDataRow").remove();
            $.each(obj, function (index, value) {
                 id=value.id;
                name=value.name;
                entry=value.time;
                details= $.parseJSON(value.data).detalii;
                consum=value.cost;
                consumed=value.consumed;
                total_general=value.total_general;
                price=value.price;
                exit=value.exitTime;
                generateClientTR(id,name,entry,details,consum,price,exit,consumed,total_general);
            });


        }
    });
    $('.clienti').find('input:text').val('');
}

function loadProducts(playgroundID)
{
    $.ajax({
        url: ApiUrl+'finance/inventory/getall/plagroundID='+playgroundID,
        type: 'GET',
        // dataType: 'json',
        success: function(data) {


            var obj = $.parseJSON(data);
            var id,name,entry,details,consum,price,exit,temmpJson;
            var jsonArray= [];
            $(".clientDataRow").remove();
            $.each(obj, function (index, value) {
                jsonArray.push(value);

            });
            generateDefaultTR(jsonArray,"clientiStart","productsDataRow")

        }
    });

}

function generateDefaultTR(fields,afterID,trClass){
    var tr="";
    var cnt=0;
     $.each(fields[0],function(k,v){

         if(cnt==0)
         {
             tr += ' <tr class=" '+trClass +' row_"' + v + '>\
            <td></td>'

         }
         else {
             tr +=  '<td>' + v +'</td>';
         }
         cnt++;

     });



    $("#"+ afterID).after(tr);
}
$(document).on('change', '.barCodeConsumCLient', function() {
//add a product to a client
    // Does some stuff and logs the event to the console
    var value=$(this).val();
    var clientID=$(this).attr("rel");

    addProduct(value,MainPlayground,addedBy,-1,clientID);
    loadClients(MainPlayground);

});
/*
$(document).on('change', '.clientNotes', function() {
//add a product to a client
    // Does some stuff and logs the event to the console
    var value=$(this).val();
    var clientID=$(this).attr("rel");

    updateClientDetails(value,MainPlayground,addedBy,clientID);
    loadClients(MainPlayground);

});
*/
function updateClientDetails(details,clientID){
    console.log("update");
    $.ajax({
        url: ApiUrl+'finance/client/'+clientID+'/comment/'+details,
        type: 'GET',
        // dataType: 'json',
        success: function(data) {
            console.log('finance/client/'+clientID+'/comment/'+details);
            loadClients(MainPlayground);
        }
    });


}

function generateClientTR(id,name,entry,details,consum,price,exit,consumed,total_general)
{
    var tr=' <tr class=" clientDataRow row_"' + id + '>\
        <td></td>\
    <td>' + name + '</td>\
    <td>' + entry + '</td>';
    if(exit=='00:00:00'){
        tr+='<td>' +'<a  class="client-comments" rel="'+id+'">'+details+'</a>'

    }
    else{
        tr+='<td>' +details
    }
    tr+='<div class="col-lg-12"><textarea  class="client-comments hide" rel="'+id+'">'+details+'</textarea></div>\
    <div class="col-lg-12"><input type="button" class="btn btn-info hide client-comments" rel="'+id+'" value="Salveaza comentariu" ></div>'
    tr+='</td>\
    <td>' ;
    if(exit=='00:00:00'){
        tr+='<div class="col-lg-12"><div class="form-group input-group"><span class="input-group-addon">'+consum+'</span>\
        <input type="text" rel="'+id+'" name="barCode" class="form-control barCodeConsumCLient"></div></div>';

    }
    else{
        tr+= + consum;

    }
    tr+= (consumed==null ? "" : '<div class="col-lg-12">'+ consumed+'</div>')


    tr+='</td>\
    <td>' + price + '</td>\
    <td>' + exit + '</td>';
    if(exit=='00:00:00')
          tr+='<td><input type="button" class="btn btn-danger inchidClient" onclick="calculateClient('+ id +')" clientID="'+ id +'" value="Inchid"> </td></tr> ';
    else
        tr+='<td>'+total_general+'</td>';
    $(".clienti").append(tr);

}

function form_to_json (selector) {
    var ary = $(selector).serializeArray();
    var obj = {};
    for (var a = 0; a < ary.length; a++) obj[ary[a].name] = ary[a].value;
    return obj;
}
function toggleSubmit(option){
    if(option==='hide')
        $("#adaug").hide();
    else
        $("#adaug").show();


}

//speciffic only to client page
$(document).on('click', 'a.client-comments', function() {
    var id=$(this).attr("rel");

    $(this).addClass("hide");
    $("textarea.client-comments[rel='"+id+"']").removeClass("hide")
    $("input.client-comments[rel='"+id+"'][type='button']").removeClass("hide")
});

$(document).on('click', 'input.client-comments', function() {
    var id=$(this).attr("rel");
    var comment= $("a.client-comments[rel='"+id+"']").html();
console.log("triggered");
    $("a.client-comments[rel='"+id+"']").removeClass("hide")
    $("textarea.client-comments[rel='"+id+"']").addClass("hide")
    $("input.client-comments[rel='"+id+"'][type='button']").addClass("hide")
    $("textarea.client-comments[rel='"+id+"']").attr('value', $(this).val())
    updateClientDetails( comment,id);

});
$(document).on('change', 'textarea.client-comments', function() {
    var id=$(this).attr("rel");
    $("a.client-comments[rel='"+id+"']").html($(this).val())
});
///finance/client/{clientID}/comment/{comment}
$("#clientSearchInput").keyup(function () {
    //split the current value of searchInput
    var data = this.value.split(" ");
    //create a jquery object of the rows
    var jo =$('tbody.clienti').find("tr");
    if (this.value == "") {
        jo.show();
        return;
    }
    //hide all the rows
    jo.hide();

    //Recusively filter the jquery object to get results.
    jo.filter(function (i, v) {
        var $t = $(this);
        for (var d = 0; d < data.length; ++d) {
            if ($t.is(":contains('" + data[d] + "')")) {
                return true;
            }
        }
        return false;
    })
    //show the rows that match.
        .show();
}).focus(function () {
    this.value = "";
    $(this).css({
        "color": "black"
    });
    $(this).unbind('focus');
}).css({
    "color": "#C0C0C0"
});