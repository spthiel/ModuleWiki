/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

import 'highlight.js/styles/monokai-sublime.css';

import hljs from "highlight.js";
import mkb from "./mkb";

hljs.registerLanguage("mkb", mkb);
// start the Stimulus application
import './bootstrap';
