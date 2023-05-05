import {Controller} from "@hotwired/stimulus";
import hljs from "highlight.js";
import mkb from '../mkb.js';

export default class extends Controller {

    static targets = ["code"];

    constructor(ctx) {
        super(ctx);
        hljs.registerLanguage("mkb", mkb);
    }

    codeTargetConnected(element) {
        if (!element.hasAttribute("highlit") && element.parentElement?.tagName === "PRE") {
            hljs.highlightElement(element);
            element.setAttribute("highlit", "true")
        }
    }

}