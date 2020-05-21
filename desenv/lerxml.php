<?php
/*
$reader = new XMLReader();
if (!$reader->open("../xmltv.php")) {
    die("Não abriu arquivo  'xmltv.php'");
}

while ($reader->read()) {
    if ($reader->nodeType == XMLReader::ELEMENT && $reader->name == 'channel') {
        $nome = $reader->getAttribute('display-name');
        echo $nome;
    }
}
$reader->close();
*/
$page = file_get_contents("../xmltv.php");
//"http://api.elsevier.com/content/search/index:SCIDIR?query=heart+attack&apiKey=20d0c7953f56925f725afe204869dadb&xml-decode=true&httpAccept=application%2Fxml");

$xml = simplexml_load_string($page);
$arrayData = xmlToArray($xml);
echo "<pre>";
print_r($arrayData);


function xmlToArray($xml, $options = array())
{
    $defaults = array(
        'namespaceSeparator' => ':', // você pode querer que isso seja algo diferente de um cólon
        'attributePrefix' => '@',    // para distinguir entre os nós e os atributos com o mesmo nome
        'alwaysArray' => array(),    // array de tags que devem sempre ser array
        'autoArray' => true,         // só criar arrays para as tags que aparecem mais de uma vez
        'textContent' => '$',        // chave utilizada para o conteúdo do texto de elementos
        'autoText' => true,          // pular chave "textContent" se o nó não tem atributos ou nós filho
        'keySearch' => false,        // pesquisa opcional e substituir na tag e nomes de atributos
        'keyReplace' => false        // substituir valores por valores acima de busca
    );
    $options = array_merge($defaults, $options);
    $namespaces = $xml->getDocNamespaces();
    $namespaces[''] = null; // adiciona namespace base(vazio)

    // Obtém os atributos de todos os namespaces
    $attributesArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->attributes($namespace) as $attributeName => $attribute) {
            // Substituir caracteres no nome do atributo
            if ($options['keySearch']) {
                $attributeName =
                    str_replace($options['keySearch'], $options['keyReplace'], $attributeName);
            }
            $attributeKey = $options['attributePrefix']
                    . ($prefix ? $prefix . $options['namespaceSeparator'] : '')
                    . $attributeName;
            $attributesArray[$attributeKey] = (string)$attribute;
        }
    }

    // Obtém nós filhos de todos os namespaces
    $tagsArray = array();
    foreach ($namespaces as $prefix => $namespace) {
        foreach ($xml->children($namespace) as $childXml) {
            // Recursividade em nós filho
            $childArray = xmlToArray($childXml, $options);
            list($childTagName, $childProperties) = each($childArray);

            // Substituir caracteres no nome da tag
            if ($options['keySearch']) {
                $childTagName =
                    str_replace($options['keySearch'], $options['keyReplace'], $childTagName);
            }
            // Adiciona um prefixo namespace, se houver
            if ($prefix) {
                $childTagName = $prefix . $options['namespaceSeparator'] . $childTagName;
            }

            if (!isset($tagsArray[$childTagName])) {
                // Só entra com esta chave
                // Testa se as tags deste tipo deve ser sempre matrizes, não importa a contagem de elementos
                $tagsArray[$childTagName] =
                        in_array($childTagName, $options['alwaysArray']) || !$options['autoArray']
                        ? array($childProperties) : $childProperties;
            } elseif (is_array($tagsArray[$childTagName]) && array_keys($tagsArray[$childTagName])
                === range(0, count($tagsArray[$childTagName]) - 1)
            ) {
                $tagsArray[$childTagName][] = $childProperties;
            } else {
                $tagsArray[$childTagName] = array($tagsArray[$childTagName], $childProperties);
            }
        }
    }

    // Obtém o texto do nó
    $textContentArray = array();
    $plainText = trim((string)$xml);
    if ($plainText !== '') {
        $textContentArray[$options['textContent']] = $plainText;
    }

    $propertiesArray = !$options['autoText'] || $attributesArray || $tagsArray || ($plainText === '')
            ? array_merge($attributesArray, $tagsArray, $textContentArray) : $plainText;

    // Retorna o nó como array
    return array(
        $xml->getName() => $propertiesArray
    );
}
