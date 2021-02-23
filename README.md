<p align="center">
    <img alt="Caterpillar Logo" src="/static/logo.png?v=1.0.0" width="200" />
    <h3 align="center">Caterpillar</h3>
    <p align="center">A Fake SMTP Server, Set up in Minutes.</p>
    <p align="center">
        <a href="https://github.com/Clivern/Caterpillar/actions/workflows/api.yml">
            <img src="https://github.com/Clivern/Caterpillar/actions/workflows/api.yml/badge.svg">
        </a>
        <a href="https://github.com/Clivern/Caterpillar/actions/workflows/ui.yml">
            <img src="https://github.com/Clivern/Caterpillar/actions/workflows/ui.yml/badge.svg">
        </a>
        <a href="https://github.com/Clivern/Caterpillar/releases">
            <img src="https://img.shields.io/badge/Version-v1.0.0-red.svg">
        </a>
        <a href="https://goreportcard.com/report/github.com/Clivern/Caterpillar">
            <img src="https://goreportcard.com/badge/github.com/clivern/Caterpillar?v=1.0.0">
        </a>
        <a href="https://godoc.org/github.com/clivern/caterpillar">
            <img src="https://godoc.org/github.com/clivern/caterpillar?status.svg">
        </a>
        <a href="https://github.com/Clivern/Caterpillar/blob/main/LICENSE">
            <img src="https://img.shields.io/badge/LICENSE-MIT-orange.svg">
        </a>
    </p>
</p>
<br/>

## Documentation

### Deployment

Download [the latest caterpillar binary](https://github.com/Clivern/Caterpillar/releases). Make it executable from everywhere.

```zsh
$ export CATEPILLAR_LATEST_VERSION=$(curl --silent "https://api.github.com/repos/Clivern/Caterpillar/releases/latest" | jq '.tag_name' | sed -E 's/.*"([^"]+)".*/\1/' | tr -d v)

$ curl -sL https://github.com/Clivern/Caterpillar/releases/download/v{$CATEPILLAR_LATEST_VERSION}/caterpillar_{$CATEPILLAR_LATEST_VERSION}_Linux_x86_64.tar.gz | tar xz
```


## Versioning

For transparency into our release cycle and in striving to maintain backward compatibility, Caterpillar is maintained under the [Semantic Versioning guidelines](https://semver.org/) and release process is predictable and business-friendly.

See the [Releases section of our GitHub project](https://github.com/clivern/caterpillar/releases) for changelogs for each release version of Caterpillar. It contains summaries of the most noteworthy changes made in each release. Also see the [Milestones section](https://github.com/clivern/caterpillar/milestones) for the future roadmap.


## Bug tracker

If you have any suggestions, bug reports, or annoyances please report them to our issue tracker at https://github.com/clivern/caterpillar/issues


## Security Issues

If you discover a security vulnerability within Caterpillar, please send an email to [hello@clivern.com](mailto:hello@clivern.com)


## Contributing

We are an open source, community-driven project so please feel free to join us. see the [contributing guidelines](CONTRIBUTING.md) for more details.


## License

© 2022, Clivern. Released under [MIT License](https://opensource.org/licenses/mit-license.php).

**Caterpillar** is authored and maintained by [@clivern](http://github.com/clivern).
