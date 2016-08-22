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
        url: 'http://daniel.dev/slim/src/public/finance/monetar/data='+JSON.stringify(formData)+'/option='+option,
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
$("#adaug").click(function(){
    var formData=form_to_json(".clienti ");

    $.ajax({
        url: 'http://daniel.dev/slim/src/public/finance/client/data='+JSON.stringify(formData)+'/option=add',
        type: 'GET',
        // dataType: 'json',
        success: function(data) {

            var dataArray = [];
            var obj = $.parseJSON(data);

            $.each(obj, function (index, value) {
                dataArray.push([ value ]);
            });

            if(dataArray[0]=='Yes'){
                loadClients(1);
                console.log('dialog OK');
                $("#alert-dimissable-text").html("Operatie reusita");
                $(".alert-dismissable").removeClass("hide");

            }
        }
    });



});

function calculateClient(id){
    $.ajax({
        url: 'http://daniel.dev/slim/src/public/finance/client/'+ id +'/option=calculate',
        type: 'POST',
        // dataType: 'json',
        success: function(data) {

            var dataArray = [];
            var obj = $.parseJSON(data);

            $.each(obj, function (index, value) {
                dataArray.push([ value ]);
            });

            if(dataArray[0]=='Yes'){
                loadClients(1);
                console.log('dialog OK');
                $("#alert-dimissable-text").html("Operatie reusita");
                $(".alert-dismissable").removeClass("hide");

            }
        }
    });



}
$( document ).ready(function() {

    if ( $('.client-data').length > 0 ) {
        loadClients(1);
    }else if( $('.product-data').length > 0)  {
        loadProducts(1);


    }

});
function loadClients(playgroundID)
{
    $.ajax({
        url: 'http://daniel.dev/slim/src/public/finance/client/getall/plagroundID='+playgroundID,
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
                consum=value.price;
                price=value.price;
                exit=value.exit;
                generateClientTR(id,name,entry,details,consum,price,exit);
            });


        }
    });

}

function loadProducts(playgroundID)
{
    $.ajax({
        url: 'http://daniel.dev/slim/src/public/finance/inventory/getall/plagroundID='+playgroundID,
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
    console.log(afterID);

    $("#"+ afterID).after(tr);
}

function generateClientTR(id,name,entry,details,consum,price,exit)
{
    var tr=' <tr class=" clientDataRow row_"' + id + '>\
        <td></td>\
    <td>' + name + '</td>\
    <td>' + entry + '</td>\
    <td>' + details + '</td>\
    <td>' + consum + '</td>\
    <td>' + price + '</td>\
    <td>' + exit + '</td>\
    <td><input type="button" class="btn btn-danger inchidClient" onclick="calculateClient('+ id +')" clientID="'+ id +'" value="Inchid"> </td>\
    </tr>   ';

    $("#clientiStart").after(tr);

}

function form_to_json (selector) {
    var ary = $(selector).serializeArray();
    var obj = {};
    for (var a = 0; a < ary.length; a++) obj[ary[a].name] = ary[a].value;
    return obj;
}