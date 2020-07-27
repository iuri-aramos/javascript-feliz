const root = document.querySelector("#root");
const textTitle = 'Dificuldade';

// Tagged template String
const title = Title`
  color:#3867d6;
  ${textTitle}
  font-size: 2.5rem;
  letter-spacing: 1.2px;
`;

root.insertAdjacentHTML('beforeend', title);
root.insertAdjacentHTML('beforeend', wrapperCharacters);
root.insertAdjacentHTML('beforeend', slide);