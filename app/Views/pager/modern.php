<?php
$pager->setSurroundCount(2);

// Jangan tampilkan pagination jika hanya 1 halaman
if ($pager->getPageCount() <= 1) {
    return;
}
?>

<style>
    .modern-pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 6px;
        padding: 16px 0;
        flex-wrap: wrap;
        list-style: none;
        margin: 0;
    }

    .modern-pagination .page-item .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 12px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        color: #475569;
        background: #f1f5f9;
        border: 2px solid transparent;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .modern-pagination .page-item .page-link:hover {
        background: #e2e8f0;
        color: #1e293b;
        border-color: #cbd5e1;
    }

    .modern-pagination .page-item.active .page-link,
    .modern-pagination .page-item.active .page-link:hover {
        background: #3b82f6 !important;
        color: #ffffff !important;
        border-color: #3b82f6 !important;
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3) !important;
    }

    .modern-pagination .page-item.disabled .page-link {
        opacity: 0.5;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* Arrow buttons */
    .modern-pagination .page-item:first-child .page-link,
    .modern-pagination .page-item:last-child .page-link {
        background: #fff;
        border: 2px solid #e2e8f0;
    }

    .modern-pagination .page-item:first-child .page-link:hover,
    .modern-pagination .page-item:last-child .page-link:hover {
        background: #3b82f6;
        color: white;
        border-color: #3b82f6;
    }
</style>

<nav aria-label="Page navigation">
    <ul class="modern-pagination">
        <?php if ($pager->hasPrevious()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getFirst() ?>" title="Halaman Pertama">
                    <i class="fas fa-angle-double-left"></i>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPrevious() ?>" title="Sebelumnya">
                    <i class="fas fa-angle-left"></i>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()): ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNext() ?>" title="Selanjutnya">
                    <i class="fas fa-angle-right"></i>
                </a>
            </li>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getLast() ?>" title="Halaman Terakhir">
                    <i class="fas fa-angle-double-right"></i>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>