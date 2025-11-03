<?php
$titulo_pagina = "Criar Novo Post"; 
$mensagem = '';
$sucesso = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = htmlspecialchars(trim($_POST['titulo']));
    $autor = htmlspecialchars(trim($_POST['autor']));
    $conteudo  = trim($_POST['conteudo']); 

    if (empty($titulo) || empty($autor) || empty($conteudo)) { $mensagem = 'Por favor, preencha todos os campos.'; }
    else {
        $xml_file = 'posts.xml';
        if (file_exists($xml_file)) { $xml = simplexml_load_file($xml_file); }
        else {
            $xml_str = '<?xml version="1.0" encoding="UTF-8"?><posts></posts>';
            $xml = simplexml_load_string($xml_str);
        }

        $novo_id = time() . rand(100, 999); 
        $data_atual = date('Y-m-d');

        $novo_post = $xml->addChild('post');
        $novo_post->addAttribute('id', $novo_id); 

        $novo_post->addChild('titulo', $titulo);
        $novo_post->addChild('autor', $autor);
        $novo_post->addChild('data', $data_atual);
    
        $dom_post = dom_import_simplexml($novo_post);
        $cdata = $dom_post->ownerDocument->createCDATASection($conteudo);
        $elemento_conteudo = $dom_post->ownerDocument->createElement('conteudo');
        $elemento_conteudo->appendChild($cdata);
        $dom_post->appendChild($elemento_conteudo);

        $dom_doc = new DOMDocument('1.0');
        $dom_doc->preserveWhiteSpace = false;
        $dom_doc->formatOutput = true;
        $dom_doc->loadXML($xml->asXML()); 
        
        if ($dom_doc->save($xml_file)) {
            $sucesso = true;
            $mensagem = "Post **'{$titulo}'** salvo com sucesso!";
            
            header("refresh:2;url=index.php"); 
        } else { $mensagem = 'Erro ao salvar o arquivo XML.'; }
    }
}

include 'header.php'; 
?>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <h2 class="mb-4">Adicionar Novo Artigo</h2>

        <?php if (!empty($mensagem)): ?>
            <div class="alert <?php echo $sucesso ? 'alert-success' : 'alert-danger'; ?>" role="alert">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="novo_post.php">
            
            <div class="mb-3">
                <label for="titulo" class="form-label">Título do Post</label>
                <input type="text" class="form-control" id="titulo" name="titulo" required>
            </div>
            
            <div class="mb-3">
                <label for="autor" class="form-label">Autor</label>
                <input type="text" class="form-control" id="autor" name="autor" required>
            </div>
            
            <div class="mb-3">
                <label for="conteudo" class="form-label">Conteúdo (Aceita HTML Básico)</label>
                <textarea class="form-control" id="conteudo" name="conteudo" rows="10" required></textarea>
            </div>
            
            <button type="submit" class="btn btn-success me-2">Salvar Post</button>
            <a href="index.php" class="btn btn-secondary">Cancelar e Voltar</a>
        </form>
    </div>
</div>

<?php include 'footer.php';  ?>