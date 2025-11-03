<?php
$titulo_pagina = "Lista de Posts"; 

include 'header.php';

if (file_exists('posts.xml')) { $xml = simplexml_load_file('posts.xml'); } 
else { $xml = false; }
?>

<div class="row">
    <h2 class="mb-4">Últimos Artigos</h2>

    <?php if ($xml && $xml->post): ?>
        <?php foreach ($xml->post as $post): 
            $post_id = htmlspecialchars($post['id']);
            $data_formatada = formatar_data_br((string) $post->data);
        ?>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title"> <?php echo htmlspecialchars($post->titulo); ?> </h5>
                    <h6 class="card-subtitle mb-2 text-muted">Por <?php echo htmlspecialchars($post->autor); ?> em <?php echo $data_formatada; ?> </h6>
                    
                    <p class="card-text"> 
                        <?php echo nl2br(htmlspecialchars(substr($post->conteudo, 0, 150))); ?>...
                    </p>
                    
                    <button type="button" class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalPost<?php echo $post_id; ?>">
                        Ler mais
                    </button>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="modalPost<?php echo $post_id; ?>" tabindex="-1" aria-labelledby="modalPostLabel<?php echo $post_id; ?>" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content">
                    
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPostLabel<?php echo $post_id; ?>"><?php echo htmlspecialchars($post->titulo); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body">
                        <p class="text-muted border-bottom pb-2 mb-4">
                            Por: <strong><?php echo htmlspecialchars($post->autor); ?></strong> | 
                            Publicado em: <strong><?php echo $data_formatada; ?></strong>
                        </p>
                        <div class="post-content lead">
                            <?php echo (string) $post->conteudo; ?>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

        <?php endforeach; ?>

    <?php else: ?>
        <div class="col-12"><div class="alert alert-info" role="alert">Nenhum post encontrado.</div></div>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>