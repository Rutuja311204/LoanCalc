<?= $this->include('layout/header') ?>

<section class="py-5">
    <div class="container-fluid px-4">
        <div class="row g-4">
            <div class="col-lg-3 col-xl-2"><?= $this->include('layout/sidebar_admin') ?></div>

            <div class="col-lg-9 col-xl-10">
                <h4 class="mb-4"><i class="bi bi-people"></i> Manage Users</h4>

                <div class="card card-custom p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Status</th><th>Joined</th><th>Actions</th></tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $u) : ?>
                                <tr>
                                    <td><?= $u['id'] ?></td>
                                    <td><?= esc($u['full_name']) ?></td>
                                    <td><?= esc($u['email']) ?></td>
                                    <td><?= esc($u['phone']) ?></td>
                                    <td><span class="badge <?= $u['status'] === 'active' ? 'bg-success' : 'bg-secondary' ?>"><?= esc(ucfirst($u['status'])) ?></span></td>
                                    <td><?= date('d M Y', strtotime($u['created_at'])) ?></td>
                                    <td class="d-flex gap-2">
                                        <a href="<?= base_url('admin/users/view/' . $u['id']) ?>" class="btn btn-sm btn-outline-primary-custom border">View</a>
                                        <form action="<?= base_url('admin/users/toggle-status/' . $u['id']) ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-warning"><?= $u['status'] === 'active' ? 'Deactivate' : 'Activate' ?></button>
                                        </form>
                                        <form action="<?= base_url('admin/users/delete/' . $u['id']) ?>" method="post" class="d-inline" onsubmit="return confirm('Delete this user permanently?');">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?= $this->include('layout/footer') ?>
