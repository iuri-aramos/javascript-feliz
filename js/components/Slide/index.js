const Item = (css, content) => (
    `<li style="${css}">${content}</li>`
)
const Slide = (css, content) => (
    `<ul style="${css}">${content}</ul>`
)

const slideContent = 'Vai';
const slide = Slide`
    width: 80%;
    height: 10px;
    background-color: yellow;
    margin-top: auto;
    ${slideContent}
    `