//Clear all values from form

export function clearForm(myFormElement) {
    let elements = myFormElement.elements;
    myFormElement.reset();

    for(let i = 0; i < elements.length; i++) {
        let field_type = elements[i].type.toLowerCase();
        switch(field_type) {
            case "text":
            case "password":
            case "textarea":
            case "hidden":
                elements[i].value = "";
                break;
            case "radio":
            case "checkbox":
                if (elements[i].checked) {
                    elements[i].checked = false;
                }
                break;
            case "select-one":
            case "select-multi":
                elements[i].selectedIndex = -1;
                break;
            default:
                break;
        }
    }
}