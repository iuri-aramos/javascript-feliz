const root = document.querySelector("#root");
const textTitle = 'Dificuldade';


// Tagged template String
const title = Title`
  color:red;
  ${textTitle}
  font-size: 16px;
`;

root.insertAdjacentHTML('beforeend', title);