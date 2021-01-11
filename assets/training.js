require('../assets/app')

import $ from 'jquery';

const routes = require('../public/assets/js/fos_js_routes.json');

import Routing from 'fos-routing';

Routing.setData(routes);



import 'codemirror/mode/sql/sql'
import CodeMirror from 'codemirror/lib/codemirror'

const textarea = document.getElementById('request')
const editor = CodeMirror.fromTextArea(textarea, {
    mode: 'text/x-sql',
    lineNumbers: true,
    indentWithTabs: true,
    smartIndent: true,
    matchBrackets : true,
    autofocus: true,
})
editor.setOption('theme', 'material')



let db = document.getElementById('valideRequest').getAttribute('database')
let user = document.getElementById('valideRequest').getAttribute('user')
$("#valideRequest").click(function(e){
    e.preventDefault();
    let rq = editor.getValue()
    console.log(rq)
    console.log(db)
    $.ajax({
            url : Routing.generate('requete'),
            type : 'GET',
            data : {
                'requete' : rq,
                'database' : db,
                'user' : user
            },
            datatype : 'json',
            success : function(data){
                $( "#responses" ).text(data);
                console.log(user)
            }
        }
    )
})


