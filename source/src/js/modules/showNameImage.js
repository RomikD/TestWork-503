export function showNameImage (name, titleAdd) {
    let nameFile = ('Selected file: ' + name.files.item(0).name);
    titleAdd.textContent = nameFile;
}