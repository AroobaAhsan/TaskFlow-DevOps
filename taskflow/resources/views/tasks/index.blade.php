
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TaskFlow | Smart Task Manager</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; font-family: Inter, system-ui, Arial, sans-serif;
            background: #f4f6fb; color: #20243a;
        }
        .layout { display: flex; min-height: 100vh; }
        aside {
            width: 235px; background: #171a35; color: white;
            padding: 30px 20px; flex-shrink: 0;
        }
        .brand { font-size: 25px; font-weight: 800; margin-bottom: 42px; }
        .brand span { color: #9c8cff; }
        .nav {
            padding: 13px 15px; border-radius: 10px; margin: 8px 0;
            color: #c7c9dd;
        }
        .nav.active { background: #7160e8; color: white; }
        .side-note { margin-top: 50px; color: #a7aac3; font-size: 13px; line-height: 1.7; }
        main { flex: 1; padding: 36px; min-width: 0; }
        .top { display: flex; justify-content: space-between; align-items: center; gap: 16px; }
        h1 { margin: 0 0 8px; font-size: 30px; }
        .muted { color: #81869c; }
        .avatar {
            background: #e8e2ff; color: #624bd1; border-radius: 50%;
            width: 44px; height: 44px; display: grid; place-items: center;
            font-weight: 800;
        }
        .stats { display: grid; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 18px; margin: 28px 0; }
        .card {
            background: white; border: 1px solid #e9ebf3; border-radius: 17px;
            padding: 22px; box-shadow: 0 5px 20px #20243a06;
        }
        .stat-label { color: #81869c; font-size: 14px; }
        .number { font-size: 32px; font-weight: 800; margin-top: 12px; }
        .purple { color: #725ce5; }
        .green { color: #18a778; }
        .orange { color: #e99a36; }
        .blue { color: #3989e8; }
        .content { display: grid; grid-template-columns: minmax(0, 1.7fr) minmax(270px, 1fr); gap: 20px; }
        h2 { font-size: 19px; margin: 0 0 20px; }
        .progress-track { height: 9px; background: #eeeefa; border-radius: 20px; overflow: hidden; margin: 14px 0; }
        .progress-fill { height: 100%; background: linear-gradient(90deg, #7765ee, #a99bff); border-radius: 20px; }
        .task { padding: 17px 0; border-bottom: 1px solid #edf0f6; }
        .task:last-child { border-bottom: 0; }
        .task-title { font-weight: 700; overflow-wrap: anywhere; }
        .task-desc { font-size: 13px; color: #81869c; margin-top: 6px; overflow-wrap: anywhere; }
        .task-meta { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-top: 12px; }
        .pill { border-radius: 20px; padding: 5px 10px; font-size: 12px; font-weight: 700; background: #f0efff; color: #705be0; }
        .pill.done { background: #e2f8ef; color: #12845e; }
        .pill.pending { background: #fff0d9; color: #a56a13; }
        .pill.high { background: #ffe5e8; color: #c84455; }
        .pill.low { background: #e5f1ff; color: #3676bd; }
        input, textarea, select {
            width: 100%; padding: 12px; border: 1px solid #e0e4ef;
            border-radius: 10px; margin: 7px 0 14px; font: inherit; background: #fff;
        }
        textarea { resize: vertical; min-height: 80px; }
        label { font-size: 13px; font-weight: 700; color: #555b72; }
        button {
            cursor: pointer; border: 0; border-radius: 9px; padding: 10px 13px;
            font-weight: 700; background: #7160e8; color: white;
        }
        button:hover { opacity: .88; }
        .small-btn { padding: 7px 9px; font-size: 12px; }
        .delete-btn { background: #fff0f1; color: #c84455; }
        .success { background: #e3f8ed; color: #16754f; padding: 13px; border-radius: 10px; margin: 20px 0; }
        .empty { color: #81869c; text-align: center; padding: 25px 0; }
        @media (max-width: 1050px) {
            .stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .content { grid-template-columns: 1fr; }
        }
        @media (max-width: 650px) {
            aside { display: none; }
            main { padding: 20px 14px; }
            h1 { font-size: 24px; }
            .stats { gap: 10px; }
            .card { padding: 16px; }
            .number { font-size: 27px; }
        }
    </style>
</head>
<body>
<div class="layout">
    <aside>
        <div class="brand">Task<span>Flow.</span></div>
        <div class="nav active">▦ &nbsp; Dashboard</div>
        <div class="nav">✓ &nbsp; My Tasks</div>
        <div class="nav">◷ &nbsp; Progress</div>
        <div class="side-note">
            SMART WORKSPACE<br><br>
            Plan your work.<br>
            Track your progress.<br>
            Achieve more every day.
        </div>
    </aside>

    <main>
        <div class="top">
            <div>
                <h1>Good work starts here 👋</h1>
                <div class="muted">Your workspace at a glance. Let's get things done.</div>
            </div>
            <div class="avatar">TF</div>
        </div>

        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="success" style="background:#fff0f1;color:#b62f45">
                Please check your input:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="stats">
            <div class="card">
                <div class="stat-label">Total Tasks</div>
                <div class="number purple">{{ $stats['total'] }}</div>
            </div>
            <div class="card">
                <div class="stat-label">Completed</div>
                <div class="number green">{{ $stats['completed'] }}</div>
            </div>
            <div class="card">
                <div class="stat-label">In Progress</div>
                <div class="number blue">{{ $stats['in_progress'] }}</div>
            </div>
            <div class="card">
                <div class="stat-label">Pending</div>
                <div class="number orange">{{ $stats['pending'] }}</div>
            </div>
        </div>

        <div class="content">
            <section class="card">
                <h2>📋 Your Tasks</h2>
                <div class="muted" style="font-size:13px">
                    {{ $stats['progress'] }}% overall completion
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width:{{ $stats['progress'] }}%"></div>
                </div>

                @forelse ($tasks as $task)
                    <div class="task">
                        <div class="task-title">{{ $task->title }}</div>
                        @if ($task->description)
                            <div class="task-desc">{{ $task->description }}</div>
                        @endif
                        <div class="task-meta">
                            <span class="pill {{ $task->status === 'completed' ? 'done' : ($task->status === 'pending' ? 'pending' : '') }}">
                                {{ str_replace('_', ' ', ucfirst($task->status)) }}
                            </span>
                            <span class="pill {{ $task->priority }}">{{ ucfirst($task->priority) }} priority</span>
                            @if ($task->due_date)
                                <span class="muted" style="font-size:12px">Due: {{ $task->due_date->format('d M Y') }}</span>
                            @endif
                        </div>
                        <div class="task-meta">
                            <form method="POST" action="{{ route('tasks.update', $task) }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" aria-label="Task status" style="margin:0;width:auto;padding:7px">
                                    <option value="pending" @selected($task->status === 'pending')>Pending</option>
                                    <option value="in_progress" @selected($task->status === 'in_progress')>In progress</option>
                                    <option value="completed" @selected($task->status === 'completed')>Completed</option>
                                </select>
                                <button class="small-btn" type="submit">Update</button>
                            </form>
                            <form method="POST" action="{{ route('tasks.destroy', $task) }}" onsubmit="return confirm('Delete this task?')">
                                @csrf
                                @method('DELETE')
                                <button class="small-btn delete-btn" type="submit">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="empty">No tasks yet. Add your first task to get started! ✨</div>
                @endforelse
            </section>

            <section class="card">
                <h2>＋ Create a Task</h2>
                <form method="POST" action="{{ route('tasks.store') }}">
                    @csrf
                    <label for="title">Task title</label>
                    <input id="title" name="title" value="{{ old('title') }}" placeholder="e.g. Complete DevOps lab" required maxlength="255">

                    <label for="description">Description</label>
                    <textarea id="description" name="description" placeholder="What needs to be done?">{{ old('description') }}</textarea>

                    <label for="priority">Priority</label>
                    <select id="priority" name="priority" required>
                        <option value="low">Low</option>
                        <option value="medium" selected>Medium</option>
                        <option value="high">High</option>
                    </select>

                    <label for="due_date">Due date</label>
                    <input id="due_date" type="date" name="due_date">

                    <button type="submit" style="width:100%;padding:13px">＋ Add Task</button>
                </form>
                <div style="margin-top:22px;background:#f6f4ff;border-radius:12px;padding:16px">
                    <strong class="purple">💡 Stay focused</strong>
                    <p class="muted" style="font-size:13px;line-height:1.6;margin-bottom:0">
                        Break big goals into small tasks and celebrate every completed step.
                    </p>
                </div>
            </section>
        </div>
        <p class="muted" style="text-align:center;font-size:12px;margin-top:28px">
            TaskFlow · Smart Task Management · Powered by Laravel
        </p>
    </main>
</div>
</body>
</html>
