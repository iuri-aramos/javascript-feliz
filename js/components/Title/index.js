function Title(css, textContent, smallContent, otherText) {
    console.log(css);
    return `<h1 style="${css[0]}${css[1]}">
                ${textContent} 
                <small>${smallContent}</small>
                <em>${otherText}</em>
            </h1>`;
}