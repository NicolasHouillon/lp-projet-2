/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/bootswatch.css'
import 'codemirror/lib/codemirror.css'
import 'codemirror/theme/material.css'
import './styles/app.scss'

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
import $ from 'jquery';
require('bootstrap')

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
editor.setValue("\n".repeat(2))

console.log(editor)
