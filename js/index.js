const root = document.querySelector("#root");

// const title = document.createElement("h1");

// title.textContent = "Dificuldade";

function newElement(tag, conteudo) {
  const title = `<${tag}>${conteudo}</${tag}>`;

  root.insertAdjacentHTML("beforeend", title);
}

// root.appendChild(title);

newElement("h1", "Dificuldade");

newElement("h4", "Demoro");