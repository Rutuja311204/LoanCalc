<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-lg-3 col-xl-2"><?= $this->include('layout/sidebar_admin') ?></div>

            <div class="col-lg-9 col-xl-10">
                <h4 class="mb-4"><i class="bi bi-envelope"></i> Contact Messages</h4>

                <div class="card card-custom p-4">
                    <?php if (empty($messages)) : ?>
                        <p class="text-muted small mb-0">No messages received yet.</p>
                    <?php else : ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light"><tr><th>Name</th><th>Email</th><th>Subject</th><th>Message</th><th>Received</th><th></th></tr></thead>
                                <tbody>
                                <?php foreach ($messages as $m) : ?>
                                    <tr class="<?= $m['is_read'] ? '' : 'fw-semibold' ?>">
                                        <td><?= esc($m['name']) ?></td>
                                        <td><?= esc($m['email']) ?></td>
                                        <td><?= esc($m['subject'] ?: '—') ?></td>
                                        <td class="text-truncate" style="max-width:250px;"><?= esc($m['message']) ?></td>
                                        <td><?= date('d M Y', strtotime($m['created_at'])) ?></td>
                                        <td>
                                            <?php if (! $m['is_read']) : ?>
                                                <form action="<?= base_url('admin/messages/mark-read/' . $m['id']) ?>" method="post">
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-primary-custom border">Mark Read</button>
                                                </form>
                                            <?php else : ?>
                                                <span class="badge bg-secondary">Read</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/footer') ?>
