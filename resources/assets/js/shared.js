function findAddressBrazil(zipInput, idCityInput, cityInput, stateInput, addressInput, neighborhoodInput) {

    if (zipInput.val() == "42.700-000") {
        //Cidade de Lauro de Freitas
        idCityInput.val('-');
        cityInput.val('Lauro de Freitas');
        stateInput.val('BA');
        addressInput.val('CENTRO');
        neighborhoodInput.val('CENTRO');

    } else {

        var request = $.ajax({
            url: "https://viacep.com.br/ws/" + zipInput.val().replace(/\D/g, '') + "/json/",
            method: "POST",
            dataType: "jsonp"
        });

        request.done(function (msg) {
            idCityInput.val(msg.ibge);
            cityInput.val(msg.localidade);
            stateInput.val(msg.uf);
            addressInput.val(msg.logradouro);
            neighborhoodInput.val(msg.bairro);
        });

        request.fail(function (jqXHR, textStatus) {
            cityInput.val('Falha na busca da cidade');
        });

    }

}

function returnAddressBrazil(zip) {
    var request = $.ajax({
        url: "https://viacep.com.br/ws/" + zip + "/json/",
        method: "POST",
        dataType: "jsonp"
    });


    var indexedAddress;

    request.done(function (msg) {
        indexedAddress["cityCode"] = msg.ibge;
        indexedAddress["cityName"] = msg.localidade;
        indexedAddress["state"] = msg.uf;
        indexedAddress["address"] = logradouro;
        indexedAddress["neighborhood"] = msg.bairro;
    });

}


//TODO: Terminar essa função
function image_url(entity, id, photo, size, alternate)
{

    if (size == undefined) {
        size = '';
    } else {
        size = '_size' + size;
    }

    if (alternate == undefined) {
        alternate = "generic.png";
    }

    if (photo == undefined || photo == "")
        return "/img/system/" + alternate;
    var splitted = photo.split('.');
    photo = '/uploads/' + entity + '/' + id + '/' + splitted[0] + size + '.' + splitted[1];


    return photo;
    /*
     $.ajax({
     url: photo,
     error: function(){
     return "/img/system/" + alternate;
     },
     success: function(){
     console.log(photo);
     return photo;
     }
     
     
     }); */
}


function insertion_sort(list) {
    var size = list.length;

    for (var i = 1; i < size; i++) {
        var pivot = list[i];
        var j = i;
        while (j > 0 && list[j - 1] > pivot) {
            list[j] = list[j - 1];
            j = j - 1;
        }
        list[j] = pivot;
    }
    return list;
}


function php_to_javascript_date(php_date) {
    var match = php_date.match(/^(\d+)-(\d+)-(\d+) (\d+)\:(\d+)\:(\d+)$/);
    var date = new Date(match[1], match[2] - 1, match[3], match[4], match[5], match[6]);

    return date;
}

function mark_as_read() {
    $(".notification-menu .content").on('click', function () {
        $.ajax({
            url: "/exam/get-next-question",
            type: "POST",
            data: {
                'question': next,
                'from-result': from_result
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            cache: false,
            success: function (data) {

            }
        });
    });
}