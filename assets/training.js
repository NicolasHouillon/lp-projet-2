import $ from 'jquery';

const routes = require('../public/assets/js/fos_js_routes.json');

import Routing from 'fos-routing';

Routing.setData(routes);


$("#valideRequest").click(function(e){
    e.preventDefault();
    let request = document.getElementById('request')
    let rq = request.value
    console.log(rq)
    console.log()
    $.ajax({
            url : Routing.generate('requete'),
            type : 'GET',
            data : 'requete=' + rq,
            datatype : 'json',
            success : function(data){
                console.log(data)
            }
        }
    )
})