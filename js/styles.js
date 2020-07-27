const style = `
* {
    margin: 0;
    padding: 0;
}

body {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    background-color: #636e72;
}

#root {
    display: flex;
    flex-direction: column;
    align-items: center;
    box-sizing: border-box;
    font-family: 'Press Start 2P', cursive;
    background-color: #27ae60;
    width: 40vw;
    min-width: 768px;
    height: 65vh;
    text-align: center;
    padding-top: 4rem;
    padding-bottom: 10rem;
}`;

const tagStyles = document.createElement('style');

tagStyles.insertAdjacentHTML('beforeend',style);

const head = document.querySelector("head");

head.insertAdjacentElement('beforeend',tagStyles);