import { Controller } from "@hotwired/stimulus";

export default class extends Controller {
    async connect() {
        const res = await fetch("http://beta.receipt.pl/api/notifications/get");
        let div = document.createElement("div");
        div.setAttribute("class", "notification-count");
        const jsonData = await res.json();
        const data = JSON.parse(JSON.stringify(jsonData));
        const count = data.data.notificationsCount;
        div.append(count);
        if (count > 0) {
            this.element.append(div);
        }
    }
}
