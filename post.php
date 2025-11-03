<?php
$titulo_pagina = "Detalhes do Post";

include 'header.php'; 

$post_encontrado = null;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_procurado = $_GET['id'];
    $xml_file = 'posts.xml';

    if (file_exists($xml_file)) {
        $xml = simplexml_load_file($xml_file);
        $resultado = $xml->xpath("//post[@id='{$id_procurado}']");

        if (!empty($resultado)) {
            $post_encontrado = $resultado[0];
            $titulo_pagina = (string) $post_encontrado->titulo; 
        }
    }
}
?>

<div class="row">
    <div class="col-lg-10 offset-lg-1">
        <?php if ($post_encontrado): ?>
            <h1 class="display-4 mb-3 text-primary"><?php echo htmlspecialchars($post_encontrado->titulo); ?></h1>

            <p class="text-muted border-bottom pb-2 mb-4">
                Por: **<?php echo htmlspecialchars($post_encontrado->autor); ?>** | 
                Publicado em: **<?php echo htmlspecialchars($post_encontrado->data); ?>**
            </p>

            <div class="post-content lead"> <?php echo (string) $post_encontrado->conteudo; ?> </div>

            <hr class="my-5">
            <a href="index.php" class="btn btn-primary btn-lg">&laquo; Voltar para a Lista de Posts</a>
        <?php else: ?>
            <div class="alert alert-warning text-center" role="alert">
                <h4 class="alert-heading">Post Não Encontrado!</h4>
                <p>O artigo com o ID especificado não existe ou a URL está incompleta.</p>

                <hr>
                <a href="index.php" class="btn btn-warning">Ir para a Página Inicial</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'footer.php'; ?>