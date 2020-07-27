const pathCharacter = 'images/hiclipart.com.png' ;

const character = Character`
  width: 25%;
  padding-top: 60px;
  ${pathCharacter}
`;

const WrapperCharacters = (css, ...children) => (
    `
        <div style="${css}">${children}
        </div>
    `
  )

const wrapperCharacters = WrapperCharacters`
    display: flex;
    justify-content: space-evenly;
    ${character + character + character}
`;

wrapperCharacters.insertAdjacentHTML('beforeend', character);
wrapperCharacters.insertAdjacentHTML('beforeend', character);
wrapperCharacters.insertAdjacentHTML('beforeend', character);