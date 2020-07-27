function Title(css, textContent) {
    console.log(css);
    return `<h1 style="${css[0]}${css[1]}">
                ${textContent} 
            </h1>`;
}