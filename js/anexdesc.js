function downloadImage(imageData) {
    const blobData = b64toBlob(imageData, 'image/jpeg');  // El segundo parámetro debe coincidir con el tipo de imagen
    const blobUrl = URL.createObjectURL(blobData);

    const anchor = document.createElement('a');
    anchor.href = blobUrl;
    anchor.target = '_blank';
    anchor.download = 'anexo.jpg';
    anchor.click();
}

function b64toBlob(dataURI, contentType) {
    const byteString = atob(dataURI);
    const ab = new ArrayBuffer(byteString.length);
    const ia = new Uint8Array(ab);

    for (let i = 0; i < byteString.length; i++) {
        ia[i] = byteString.charCodeAt(i);
    }

    return new Blob([ab], { type: contentType });
}