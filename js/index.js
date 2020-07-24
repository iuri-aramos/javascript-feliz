const root = document.querySelector("#root");
const textTitle = 'Dificuldade';
const otherText = 'Outro texto';

// Tagged template String
const title = Title`
  color:red;
  ${textTitle}
  font-size: 20px;
  ${'textoPequeno'}
  ${otherText}
`;

root.insertAdjacentHTML('beforeend', title);