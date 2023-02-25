import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    async connect() {
        const res = await fetch("http://beta.receipt.pl/api/notifications/get");
        let div = document.createElement("div");
        div.setAttribute("class", "notification-count");
        const data = await res.json();
        const count = JSON.parse(data);
        div.append(count);
        if (count > 0) {
            this.element.append(div);
        }
    }
}
