import {Controller} from "@hotwired/stimulus";
import hljs from "highlight.js";

export default class extends Controller {

    static targets = ["code"];

    codeTargetConnected(element) {
        if (!element.hasAttribute("highlit") && element.parentElement?.tagName === "PRE") {
            hljs.highlightElement(element);
            element.setAttribute("highlit", "true")
        }
    }

}