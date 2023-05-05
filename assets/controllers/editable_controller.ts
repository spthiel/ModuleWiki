import {Controller} from "@hotwired/stimulus";


export default class extends Controller {

    static values = {
        loadUrl: String,
        saveUrl: String
    }

    declare readonly loadUrlValue: string
    declare readonly saveUrlValue: string

    connect() {
        console.log(this.loadUrlValue);
    }

    open() {
        const newElement = document.createElement("textarea");
        fetch(this.loadUrlValue)
            .then(res => res.text())
            .then(text => {
                newElement.value = text;
                this.element.replaceWith(newElement);
            })
    }

}