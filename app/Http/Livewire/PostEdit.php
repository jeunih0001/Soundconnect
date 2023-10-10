<?php

namespace App\Http\Livewire;

use Closure;
use App\Models\Post;
use Livewire\Component;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Concerns\InteractsWithForms;

class PostEdit extends Component implements HasForms
{
    use InteractsWithForms;
    public $user_id;
    public $community_id;
    public $caption;
    public $audio_file;
    public $tags;
    public $type;
    public $license;
    public $bpm;
    public $post;
    public function mount($post_id)
    {
        $this->post = Post::findOrFail($post_id);
        $this->form->fill([
            'user_id' => $this->post->user->id,   
            'caption' => $this->post->caption,
            'audio_file' => $this->post->audio_file,
            'tags' => $this->post->tags,
            'type' => $this->post->type,
            'license' => $this->post->license,
            'bpm' => $this->post->bpm,
            'genre' => $this->post->genre,
        ]);
        if($this->post->community_id)
        {
            $this->form->fill([
                'community_id' => $this->post->community->id,
            ]);
            
        }
    }
    protected function getFormSchema(): array 
    {
        return ([
            Wizard::make([
                Step::make('Post Info')     
                ->schema([
                    Grid::make(3)
                    ->schema([
                        Hidden::make('user_id')
                        ->required(),

                    Select::make('community_id')
                        ->options(auth()->user()->communities->pluck('handle_name', 'id'))
                        ->searchable()
                        ->label("Choose a community")
                        ->columnSpan(2),

                    Select::make('type')
                        ->options([
                            'song' => 'Song',
                            'text' => 'Text',
                            'instrumental' => 'Instrumental',
                            'vocal' => 'Vocal',
                        ])->disabled(),

                    RichEditor::make('caption')
                        ->label('What do you have on your mind')
                        ->hint('Or just the name of your audio file')
                        ->columnSpan(4)
                        ->required(),
                    ])
                    ]),
                Step::make('Audio File Info')
                ->schema([
                    FileUpload::make('audio_file')
                        ->label('Upload your file')
                        ->acceptedFileTypes(['audio/wav', 'audio/mpeg'])
                        ->hint('Your file must end with extension .wav or .mp3')
                        ->maxSize(1024 * 10)
                        ->directory('audios')
                        ->columnSpan(2),
                    Select::make('genre')
                        ->options([
                            'All Genres' => 'All Genres',
                            '8Bit Chiptune' => '8Bit Chiptune',
                            'Acid' => 'Acid',
                            'Acoustic' => 'Acoustic',
                            'Afrobeat' => 'Afrobeat',
                            'Ambient' => 'Ambient',
                            'Big Room' => 'Big Room',
                            'Blues' => 'Blues',
                            'Boom Bap' => 'Boom Bap',
                            'Breakbeat' => 'Breakbeat',
                            'Chill Out' => 'Chill Out',
                            'Cinematic' => 'Cinematic',
                            'Classical' => 'Classical',
                            'Comedy' => 'Comedy',
                            'Country' => 'Country',
                            'Crunk' => 'Crunk',
                            'Dance' => 'Dance',
                            'Dancehall' => 'Dancehall',
                            'Deep House' => 'Deep House',
                            'Dirty' => 'Dirty',
                            'Disco' => 'Disco',
                            'Drum And Bass' => 'Drum And Bass',
                            'Dub' => 'Dub',
                            'Dubstep' => 'Dubstep',
                            'EDM' => 'EDM',
                            'Electro' => 'Electro',
                            'Electronic' => 'Electronic',
                            'Ethnic' => 'Ethnic',
                            'Folk' => 'Folk',
                            'Funk' => 'Funk',
                            'Fusion' => 'Fusion',
                            'Garage' => 'Garage',
                            'Glitch' => 'Glitch',
                            'Gospel' => 'Gospel',
                            'Grime' => 'Grime',
                            'Grunge' => 'Grunge',
                            'Hardcore' => 'Hardcore',
                            'Hardstyle' => 'Hardstyle',
                            'Heavy Metal' => 'Heavy Metal',
                            'Hip Hop' => 'Hip Hop',
                            'House' => 'House',
                            'Indie' => 'Indie',
                            'Industrial' => 'Industrial',
                            'Jazz' => 'Jazz',
                            'Jungle' => 'Jungle',
                            'Latin' => 'Latin',
                            'Lo-Fi' => 'Lo-Fi',
                            'Moombahton' => 'Moombahton',
                            'Orchestral' => 'Orchestral',
                            'Phonk' => 'Phonk',
                            'Pop' => 'Pop',
                            'Psychedelic' => 'Psychedelic',
                            'Punk' => 'Punk',
                            'Rap' => 'Rap',
                            'Rave' => 'Rave',
                            'Reggae' => 'Reggae',
                            'Reggaeton' => 'Reggaeton',
                            'RnB' => 'RnB',
                            'Rock' => 'Rock',
                            'Samba' => 'Samba',
                            'Ska' => 'Ska',
                            'Soul' => 'Soul',
                            'Spoken Word' => 'Spoken Word',
                            'Techno' => 'Techno',
                            'Trance' => 'Trance',
                            'Trap' => 'Trap',
                            'Trip Hop' => 'Trip Hop',
                            'UK Drill' => 'UK Drill',
                            'Weird' => 'Weird',
                        ])
                        ->searchable()

                        ->label('Music genre of the audio'),
                    TextInput::make('bpm')
                        ->label('Tempo of the audio'),
                    TagsInput::make('tags')
                        ->separator(',')
                        ->label('Tags')
                        ->suggestions([
                            'hip hop',
                            'afro',
                            'rng',
                            'Accappella',
                        ]),

                    Select::make('license')
                        ->options([
                            'free' => 'Free',
                            'premium' => 'Premium',
                        ])
                        ->searchable()
                        ->default('Free'),
                ])
                ->hidden(fn (Closure $get) => $get('type') === 'text'),
            ])->submitAction(new HtmlString("<button id='btn' class='mb-2 float-left relative inline-flex items-center px-4 text-sm py-2 bg-primary border border-transparent rounded-md font-semibold text-white capitalize tracking-widest hover:bg-primary-700 focus:bg-primary-700 active:bg-primary-900 focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition ease-in-out duration-150']) }}>
            <span wire:loading.class='opacity-0'>Save Changes</span>
        <div wire:loading class='absolute inset-0 m-auto h-3/5 aspect-square animate-spin border-t-primary border-4 rounded-full'></div>
        </button>
        "))->skippable(),

        ]);
    } 
    public function render()
    {
        return view('livewire.post-edit');
    }
    public function submit()
    {
        $this->post->update($this->form->getState());
        return redirect()->route('post.show', ['id'=> $this->post->id])->with('message', 'Changes saved');
    }
    public function deletePost()
    {
        $this->post->delete();
        return redirect()->route('home')->with('message', 'Post deleted');
    }
}
